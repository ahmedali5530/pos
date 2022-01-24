<?php


namespace App\Command\Crud\Update;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;

class UpdateCommandHandler
{
    private string $entityName;

    private string $entityClass;

    private ClassGenerator $generator;

    private EntityManagerInterface $entityManager;

    const EXCLUDE = ['id', 'isActive', 'createdAt', 'deletedAt', 'updatedAt', 'uuid'];

    const METHOD_BODIES = [
        '__construct' => <<<CODE
parent::__construct(\$entityManager);
\$this->validator = \$validator;
CODE,
        'handle' => '',
        'getEntityClass' => <<<CODE
return {entityName}::class;
CODE
    ];

    const METHOD_PARAMETERS = [
        '__construct' => ['entityManager' => 'EntityManagerInterface', 'validator' => 'ValidatorInterface'],
        'handle' => ['command' => 'Update{entityName}Command']
    ];

    const CLASS_PROPERTIES = [
        'validator'
    ];

    const USES = [
        'Doctrine\ORM\EntityManagerInterface',
        'App\Core\Entity\EntityManager\EntityManager',
        'Symfony\Component\Validator\Validator\ValidatorInterface',
        'App\Entity\{entityName}'
    ];

    private $path;

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
        foreach (self::USES as $use) {
            $this->generator->addUse($this->replace($use));
        }

        $this->generator->setExtendedClass('EntityManager');
        $this->generator->setImplementedInterfaces([
            sprintf('Update%1$sCommandHandlerInterface', $this->entityName)
        ]);
        $this->generator->setName(sprintf('Update%sCommandHandler', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\%1$s\Command\Update%1$sCommand', $this->entityName));

        foreach (self::CLASS_PROPERTIES as $property) {
            $this->generator->addProperty($property);
        }

        $entityProperties = $this->entityManager->getClassMetadata($this->entityClass)->fieldMappings;

        foreach (self::METHOD_BODIES as $name => $body) {
            $method = new MethodGenerator($name);
            $method->setBody($this->replace($body));

            foreach (self::METHOD_PARAMETERS[$name] ?? [] as $parameter => $type) {
                $method->setParameter(
                    new ParameterGenerator($this->replace($parameter), $this->replace($type))
                );
            }

            $this->generator->addMethodFromGenerator($method);
        }

        //update handle function body
        $fields = '';
        foreach ($entityProperties as $mapping) {
            if (in_array($mapping['fieldName'], self::EXCLUDE)) {
                continue;
            }

            $fieldName = ucwords($mapping['fieldName']);
            $fields .= <<<FIELD
if(\$command->get$fieldName() !== null){
    \$item->set$fieldName(\$command->get$fieldName());
}

FIELD;
        }

        $this->generator->getMethod('handle')->setBody(<<<BODY
/** @var {$this->entityName} \$item */
\$item = \$this->getRepository()->find(\$command->getId());

if (\$item === null) {
    return Update{$this->entityName}CommandResult::createNotFound();
}

$fields

//validate item before creation
\$violations = \$this->validator->validate(\$item);
if(\$violations->count() > 0){
    return Update{$this->entityName}CommandResult::createFromConstraintViolations(\$violations);
}

\$this->persist(\$item);
\$this->flush();

\$result = new Update{$this->entityName}CommandResult();
\$result->set$this->entityName(\$item);

return \$result;
BODY
        )->setReturnType(sprintf('Update%1$sCommandResult', $this->entityName));

        $this->generator->getMethod('getEntityClass')
            ->setVisibility(MethodGenerator::VISIBILITY_PROTECTED)
            ->setReturnType('string');

        file_put_contents(sprintf('%2$s/Update%1$sCommandHandler.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }

    protected function replace($subject)
    {
        return str_replace('{entityName}', $this->entityName, $subject);
    }
}