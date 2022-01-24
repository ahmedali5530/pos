<?php


namespace App\Command\Crud\Select;


use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\InterfaceGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;

class SelectQueryHandlerInterface
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
        $this->generator->setName(sprintf('Select%sQueryHandlerInterface', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\%1$s\Query\Select%1$sQuery', $this->entityName));

        $parameter = new ParameterGenerator('command', sprintf('Select%sQuery', $this->entityName));
        $method = new MethodGenerator('handle');
        $method->setParameter($parameter);
        $method->setReturnType(sprintf('Select%sQueryResult', $this->entityName));

        $this->generator->addMethodFromGenerator($method);

        file_put_contents(sprintf('%2$s/Select%1$sQueryHandlerInterface.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }

    protected function replace($subject)
    {
        return str_replace('{entityName}', $this->entityName, $subject);
    }
}