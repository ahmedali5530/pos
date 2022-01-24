<?php


namespace App\Command\Crud\Select;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\MethodGenerator;

class SelectQueryResult
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

    const PROPERTIES = [
        ['fieldName' => 'list'],
        ['fieldName' => 'count'],
        ['fieldName' => 'total'],
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
        foreach (self::USES as $use) {
            $this->generator->addUse($this->replace($use));
        }

        foreach (self::TRAITS as $trait) {
            $this->generator->addTrait($this->replace($trait));
        }

        $this->generator->setName(sprintf('Select%sQueryResult', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\%1$s\Query\Select%1$sQuery', $this->entityName));

        foreach(self::PROPERTIES as $property){
            $fieldLower = lcfirst($property['fieldName']);
            $fieldName = ucwords($property['fieldName']);
            $this->generator->addProperty($fieldLower);
            $this->generator->addMethod('set' . $fieldName, [$fieldLower], MethodGenerator::FLAG_PUBLIC, <<<BODY
\$this->$fieldLower = \${$fieldLower};
BODY
            );
            $this->generator->addMethod('get' . $fieldName, [], MethodGenerator::FLAG_PUBLIC, <<<BODY
return \$this->$fieldLower;
BODY
            );
        }

        file_put_contents(sprintf('%2$s/Select%1$sQueryResult.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }

    protected function replace($subject)
    {
        return str_replace('{entityName}', $this->entityName, $subject);
    }
}