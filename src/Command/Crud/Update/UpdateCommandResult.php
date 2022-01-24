<?php


namespace App\Command\Crud\Update;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\MethodGenerator;

class UpdateCommandResult
{
    private string $entityName;

    private string $entityClass;

    private ClassGenerator $generator;

    private EntityManagerInterface $entityManager;

    const TRAITS = [
        'CqrsResultEntityNotFoundTrait',
        'CqrsResultValidationTrait'
    ];

    const USES = [
        'App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait',
        'App\Core\Cqrs\Traits\CqrsResultValidationTrait'
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

        foreach (self::TRAITS as $trait) {
            $this->generator->addTrait($this->replace($trait));
        }

        $this->generator->setName(sprintf('Update%sCommandResult', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\%1$s\Command\Update%1$sCommand', $this->entityName));

        $entityLower = lcfirst($this->entityName);
        $this->generator->addProperty($entityLower);
        $this->generator->addMethod('set' . $this->entityName, [$entityLower], MethodGenerator::FLAG_PUBLIC, <<<BODY
\$this->$entityLower = \${$entityLower};
BODY
        );
        $this->generator->addMethod('get' . $this->entityName, [], MethodGenerator::FLAG_PUBLIC, <<<BODY
return \$this->$entityLower;
BODY
        );

        file_put_contents(sprintf('%2$s/Update%1$sCommandResult.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }

    protected function replace($subject)
    {
        return str_replace('{entityName}', $this->entityName, $subject);
    }
}