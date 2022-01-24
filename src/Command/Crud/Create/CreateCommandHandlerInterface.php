<?php


namespace App\Command\Crud\Create;


use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\InterfaceGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;

class CreateCommandHandlerInterface
{
    private string $entityName;

    private string $entityClass;

    private InterfaceGenerator $generator;

    private EntityManagerInterface $entityManager;

    private $path;

    public function __construct(
        $entityName, $entityClass, InterfaceGenerator $generator, EntityManagerInterface $entityManager, $path
    )
    {
        $this->entityName = $entityName;
        $this->entityClass = $entityClass;
        $this->generator = $generator;
        $this->entityManager = $entityManager;
        $this->path = $path;
    }

    public function generate()
    {
        $this->generator->setName(sprintf('Create%sCommandHandlerInterface', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\%1$s\Command\Create%1$sCommand', $this->entityName));

        $parameter = new ParameterGenerator('command', sprintf('Create%sCommand', $this->entityName));
        $method = new MethodGenerator('handle');
        $method->setParameter($parameter);
        $method->setReturnType(sprintf('Create%sCommandResult', $this->entityName));

        $this->generator->addMethodFromGenerator($method);

        file_put_contents(sprintf('%2$s/Create%1$sCommandHandlerInterface.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }

    protected function replace($subject)
    {
        return str_replace('{entityName}', $this->entityName, $subject);
    }
}