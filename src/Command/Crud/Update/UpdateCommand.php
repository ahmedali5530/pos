<?php


namespace App\Command\Crud\Update;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;
use Laminas\Code\Generator\PropertyGenerator;

class UpdateCommand
{
    private string $entityName;

    private string $entityClass;

    private ClassGenerator $generator;

    private EntityManagerInterface $entityManager;

    const EXCLUDE = ['isActive', 'createdAt', 'deletedAt', 'updatedAt', 'uuid'];

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
        $this->generator->setName(sprintf('Update%sCommand', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\%1$s\Command\Update%1$sCommand', $this->entityName));

        $entityProperties = $this->entityManager->getClassMetadata($this->entityClass)->fieldMappings;
        foreach ($entityProperties as $mapping) {
            if (in_array($mapping['fieldName'], self::EXCLUDE)) {
                continue;
            }

            $property = new PropertyGenerator();
            $property->setName($mapping['fieldName']);
            $property->setFlags(AbstractMemberGenerator::FLAG_PRIVATE);
            $property->setDocBlock(
                '@var null|' . str_replace('?', '', $this->getPhpType($mapping['type']))
            );

            $this->generator->addPropertyFromGenerator($property);

            //create getter and setters
            $this->generator->addMethod('set' . ucwords($mapping['fieldName']), [
                new ParameterGenerator($mapping['fieldName'], $this->getPhpType($mapping['type']))
            ], MethodGenerator::FLAG_PUBLIC, <<<BODY
\$this->$mapping[fieldName] = \${$mapping['fieldName']};
return \$this;
BODY
            );
            $this->generator->addMethod('get' . ucwords($mapping['fieldName']), [], MethodGenerator::FLAG_PUBLIC, <<<BODY
return \$this->$mapping[fieldName];
BODY
            );
        }

        file_put_contents(sprintf('%2$s/Update%1$sCommand.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }
}
