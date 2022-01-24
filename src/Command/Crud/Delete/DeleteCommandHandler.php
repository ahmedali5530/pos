<?php


namespace App\Command\Crud\Delete;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;

class DeleteCommandHandler
{
    private string $entityName;

    private string $entityClass;

    private ClassGenerator $generator;

    private EntityManagerInterface $entityManager;

    const METHOD_BODIES = [
        '__construct' => <<<CODE
parent::__construct(\$entityManager);
\$this->validator = \$validator;
CODE,
        'handle' => <<<CODE
/** @var {entityName} \$item */
\$item = \$this->getRepository()->find(\$command->getId());

if (\$item === null) {
    return Delete{entityName}CommandResult::createNotFound();
}

\$this->remove(\$item);
\$this->flush();

\$result = new Delete{entityName}CommandResult();

return \$result;
CODE,
        'getEntityClass' => <<<CODE
return {entityName}::class;
CODE
    ];

    const METHOD_PARAMETERS = [
        '__construct' => ['entityManager' => 'EntityManagerInterface', 'validator' => 'ValidatorInterface'],
        'handle' => ['command' => 'Delete{entityName}Command']
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
            sprintf('Delete%1$sCommandHandlerInterface', $this->entityName)
        ]);
        $this->generator->setName(sprintf('Delete%sCommandHandler', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\%1$s\Command\Delete%1$sCommand', $this->entityName));

        foreach (self::CLASS_PROPERTIES as $property) {
            $this->generator->addProperty($property);
        }

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

        $this->generator->getMethod('handle')->setReturnType(sprintf('Delete%1$sCommandResult', $this->entityName));

        $this->generator->getMethod('getEntityClass')
            ->setVisibility(MethodGenerator::VISIBILITY_PROTECTED)
            ->setReturnType('string');

        file_put_contents(sprintf('%2$s/Delete%1$sCommandHandler.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }

    protected function replace($subject)
    {
        return str_replace('{entityName}', $this->entityName, $subject);
    }
}