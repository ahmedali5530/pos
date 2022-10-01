<?php


namespace App\Command\Crud;


use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\GenericTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;

class GenerateCrud
{
    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var ClassGenerator
     */
    private $generator;

    /**
     * @var string
     */
    private $entityName;

    const CLASS_USES = [
        'App\Core\Dto\Controller\Api\Admin\{entityName}\Create{entityName}RequestDto',
        'App\Core\Dto\Controller\Api\Admin\{entityName}\Select{entityName}ListResponseDto',
        'App\Core\Dto\Controller\Api\Admin\{entityName}\Select{entityName}RequestDto',
        'App\Core\Dto\Controller\Api\Admin\{entityName}\Select{entityName}ResponseDto',
        'App\Core\Dto\Controller\Api\Admin\{entityName}\Update{entityName}RequestDto',
        'App\Core\{entityName}\Command\Create{entityName}Command\Create{entityName}Command',
        'App\Core\{entityName}\Command\Create{entityName}Command\Create{entityName}CommandHandlerInterface',
        'App\Core\{entityName}\Command\Delete{entityName}Command\Delete{entityName}Command',
        'App\Core\{entityName}\Command\Delete{entityName}Command\Delete{entityName}CommandHandlerInterface',
        'App\Core\{entityName}\Command\Update{entityName}Command\Update{entityName}Command',
        'App\Core\{entityName}\Command\Update{entityName}Command\Update{entityName}CommandHandlerInterface',
        'App\Core\{entityName}\Query\Select{entityName}Query\Select{entityName}Query',
        'App\Core\{entityName}\Query\Select{entityName}Query\Select{entityName}QueryHandlerInterface',
        'App\Core\Validation\ApiRequestDtoValidator',
        'App\Entity\{entityName}',
        'App\Factory\Controller\ApiResponseFactory',
        'Nelmio\ApiDocBundle\Annotation\Model',
        'OA' => 'OpenApi\Annotations',
        'Symfony\Bundle\FrameworkBundle\Controller\AbstractController',
        'Symfony\Component\HttpFoundation\Request',
        'Symfony\Component\Routing\Annotation\Route',
    ];

    const METHOD_NAMES = ['list', 'create', 'getById', 'update', 'delete'];

    const METHOD_DOCBLOCKS = ['list' =>
        <<<BLOCK
@Route("/list", methods={"GET"}, name="list")

@OA\Parameter(
  name="name",
  in="query",
  description="Search in name"
)

@OA\Parameter(
  name="limit",
  in="query",
  description="limit the results"
)

@OA\Parameter(
  name="offset",
  in="query",
  description="start the results from offset"
)

@OA\Response(
  @Model(type=Select{entityName}ListResponseDto::class), response="200", description="OK"
)
BLOCK,
        'create' => <<<BLOCK
@Route("/create", methods={"POST"}, name="create")

@OA\RequestBody(
  @Model(type=Create{entityName}RequestDto::class)
)

@OA\Response(
  response="200", description="OK", @Model(type=Select{entityName}ResponseDto::class)
)

@OA\Response(
  response="422", description="Validations"
)

@OA\Response(
  response="404", description="Not found"
)
BLOCK,
        'getById' => <<<BLOCK
@Route("/{id}", methods={"GET"}, name="get")

@OA\Response(
  response="200", description="OK", @Model(type=Select{entityName}ResponseDto::class)
)

@OA\Response(
  response="404", description="Not found"
)
BLOCK,
        'update' => <<<BLOCK
@Route("/{id}", methods={"POST"}, name="update")

@OA\RequestBody(
  @Model(type=Update{entityName}RequestDto::class)
)

@OA\Response(
  response="200", description="OK", @Model(type=Select{entityName}ResponseDto::class)
)

@OA\Response(
  response="422", description="Validations"
)

@OA\Response(
  response="404", description="Not found"
)
BLOCK,
        'delete' => <<<BLOCK
@Route("/{id}", methods={"DELETE"}, name="delete")

@OA\Response(
  response="200", description="OK"
)

@OA\Response(
  response="404", description="Not found"
)
BLOCK
    ];

    const METHOD_PARAMETERS = [
        'list' => [
            'request' => 'Request',
            'responseFactory' => 'ApiResponseFactory',
            'requestDtoValidator' => 'ApiRequestDtoValidator',
            'handler' => 'Select{entityName}QueryHandlerInterface'
        ],
        'create' => [
            'request' => 'Request',
            'requestDtoValidator' => 'ApiRequestDtoValidator',
            'responseFactory' => 'ApiResponseFactory',
            'handler' => 'Create{entityName}CommandHandlerInterface'
        ],
        'getById' => [
            'entity' => '{entityName}',
            'responseFactory' => 'ApiResponseFactory'
        ],
        'update' => [
            'request' => 'Request',
            'requestDtoValidator' => 'ApiRequestDtoValidator',
            'responseFactory' => 'ApiResponseFactory',
            'handler' => 'Update{entityName}CommandHandlerInterface'
        ],
        'delete' => [
            'id',
            'responseFactory' => 'ApiResponseFactory',
            'handler' => 'Delete{entityName}CommandHandlerInterface'
        ]
    ];

    const METHOD_BODIES = [
        'list' => <<<CODE
\$requestDto = Select{entityName}RequestDto::createFromRequest(\$request);

\$query = new Select{entityName}Query();

\$requestDto->populateQuery(\$query);

\$list = \$handler->handle(\$query);

\$responseDto = Select{entityName}ListResponseDto::createFromResult(\$list);

return \$responseFactory->json(\$responseDto);
CODE,
        'create' => <<<CODE
\$requestDto = Create{entityName}RequestDto::createFromRequest(\$request);
if(null !== \$violations = \$requestDtoValidator->validate(\$requestDto)){
    return \$responseFactory->validationError(\$violations);
}

\$command = new Create{entityName}Command();
\$requestDto->populateCommand(\$command);

\$result = \$handler->handle(\$command);

if(\$result->hasValidationError()){
    return \$responseFactory->validationError(\$result->getValidationError());
}

if(\$result->isNotFound()){
    return \$responseFactory->notFound(\$result->getNotFoundMessage());
}

return \$responseFactory->json(
    Select{entityName}ResponseDto::createFrom{entityName}(\$result->get{entityName}())
);
CODE,
        'getById' => <<<CODE
if(\$entity === null){
    return \$responseFactory->notFound('{entityName} not found');
}

return \$responseFactory->json(
    Select{entityName}ResponseDto::createFrom{entityName}(\$entity)
);
CODE,
        'update' => <<<CODE
\$requestDto = Update{entityName}RequestDto::createFromRequest(\$request);
if(null !== \$violations = \$requestDtoValidator->validate(\$requestDto)){
    return \$responseFactory->validationError(\$violations);
}

\$command = new Update{entityName}Command();
\$requestDto->populateCommand(\$command);

\$result = \$handler->handle(\$command);

if(\$result->hasValidationError()){
    return \$responseFactory->validationError(\$result->getValidationError());
}

if(\$result->isNotFound()){
    return \$responseFactory->notFound(\$result->getNotFoundMessage());
}

return \$responseFactory->json(
    Select{entityName}ResponseDto::createFrom{entityName}(\$result->get{entityName}())
);
CODE,
        'delete' => <<<CODE
\$command = new Delete{entityName}Command();
\$command->setId(\$id);

\$result = \$handler->handle(\$command);

if(\$result->isNotFound()){
    return \$responseFactory->notFound(\$result->getNotFoundMessage());
}

return \$responseFactory->json();
CODE

    ];

    private $path;

    public function __construct(
        ClassGenerator $generator, $controller, $entity, $entityName, $path
    )
    {
        $this->generator = $generator;
        $this->controller = $controller;
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->path = $path;
    }

    public static function getPhpType(string $type): string
    {
        $phpTypes = [
            'integer' => '?int',
            'datetime' => '?\DateTimeInterface',
            'date' => '?\DateTimeInterface',
            'decimal' => '?float',
            'boolean' => '?bool',
            'text' => '?string',
            'datetime_immutable' => '?\DateTimeImmutable',
            'json' => '?string'
        ];

        return $phpTypes[$type] ?? '?' . $type;
    }

    public function generate()
    {
        $this->getGenerator()->setName($this->getController());
        $this->generator->setExtendedClass('AbstractController');
        foreach(self::CLASS_USES as $alias => $class){
            $this->getGenerator()->addUse(str_replace('{entityName}', $this->entityName, $class), is_int($alias) ? null : $alias);
        }

        $this->generator->setDocBlock(
            new DocBlockGenerator(null, null, [
                new GenericTag(sprintf('@Route("/admin/%1$s", name="admin_%1$ss_")', strtolower($this->entityName))),
                new GenericTag('OA\Tag(name="Admin")')
            ])
        );

        foreach (self::METHOD_NAMES as $methodName) {
            $method = new MethodGenerator($methodName, [], MethodGenerator::FLAG_PUBLIC);
            $method->setDocBlock(str_replace('{entityName}', $this->getEntityName(), self::METHOD_DOCBLOCKS[$methodName]));

            $parameters = [];
            foreach(self::METHOD_PARAMETERS[$methodName] as $paramName => $paramType){
                $parameter = new ParameterGenerator();
                if(is_int($paramName)){
                    $parameter->setName($paramType);
                }else{
                    $parameter->setName($paramName);
                    $parameter->setType(str_replace('{entityName}', $this->getEntityName(), $paramType));
                }

                $parameters[] = $parameter;
            }

            $method->setParameters($parameters);

            $method->setBody(str_replace('{entityName}', $this->getEntityName(), self::METHOD_BODIES[$methodName]));

            $this->getGenerator()->addMethodFromGenerator(
                $method
            );
        }

        file_put_contents(sprintf('%2$s/%1$sController.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     */
    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return ClassGenerator
     */
    public function getGenerator(): ClassGenerator
    {
        return $this->generator;
    }

    /**
     * @param ClassGenerator $generator
     */
    public function setGenerator(ClassGenerator $generator): void
    {
        $this->generator = $generator;
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     */
    public function setEntityName(string $entityName): void
    {
        $this->entityName = $entityName;
    }

}
