<?php


namespace App\Command\Crud\Select;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;
use Laminas\Code\Generator\PropertyGenerator;

class SelectListResponseDto
{
    private string $entityName;

    private string $entityClass;

    private ClassGenerator $generator;

    private EntityManagerInterface $entityManager;

    private $path;

    const USES = [
        'App\Core\Dto\Common\%1$s\%1$sDto',
        'App\Core\%1$s\Query\Select%1$sQuery\Select%1$sQueryResult'
    ];

    public function __construct(
        $entityName, $entityClass, ClassGenerator $generator, EntityManagerInterface $entityManager, $path
    )
    {
        $this->entityName = $entityName;
        $this->entityClass = $entityClass;
        $this->generator = $generator;
        $this->entityManager = $entityManager;
        $this->path = $path;
    }

    public function getPhpType($type)
    {
        return GenerateCrud::getPhpType($type);
    }

    public function generate()
    {
        $this->generator->setName(sprintf('Select%1$sListResponseDto', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\Dto\Controller\Api\Admin\%1$s', $this->entityName));

        foreach(self::USES as $use){
            $this->generator->addUse(sprintf($use, $this->entityName));
        }

        $parameter = new ParameterGenerator('result', sprintf('Select%sQueryResult', $this->entityName));
        $createMethod = new MethodGenerator('createFromResult', [
            $parameter
        ]);
        $createMethod->setReturnType('self');
        $createMethod->setStatic(true);

        $createMethod->setBody(<<<BODY
\$dto = new self();

foreach(\$result->getList() as \$list){
    \$dto->list[] = {$this->entityName}Dto::createFrom{$this->entityName}(\$list);
}

\$dto->total = \$result->getTotal();
\$dto->count = count(\$dto->list);

return \$dto;
BODY
);

        $this->generator->addMethodFromGenerator($createMethod);

        $types = [
            'list' => <<<DOC
@var {entityName}Dto[]
DOC,
            'total' => <<<DOC
@var int
DOC,
            'count' => <<<DOC
@var int
DOC,
        ];
        $methods = [
            'list', 'total', 'count'
        ];

        $defaults = [
            'list' => [],
            'total' => 0,
            'count' => 0
        ];

        foreach($methods as $method){
            $property = new PropertyGenerator($method, $defaults[$method], PropertyGenerator::FLAG_PRIVATE);
            $property->setDocBlock(str_replace('{entityName}', $this->entityName, $types[$method]));
            $this->generator->addPropertyFromGenerator($property);

            $this->generator->addMethod('set'.ucwords($method), [
                new ParameterGenerator($method)
            ], MethodGenerator::FLAG_PUBLIC, <<<BODY
\$this->{$method} = \${$method};
BODY
);
            $this->generator->addMethod('get' . ucwords($method), [], MethodGenerator::FLAG_PUBLIC, <<<BODY
return \$this->{$method};
BODY
);
        }

        file_put_contents(sprintf('%2$s/Select%1$sListResponseDto.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }
}
