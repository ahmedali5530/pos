<?php


namespace App\Command\Crud\Update;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;
use Laminas\Code\Generator\PropertyGenerator;

class UpdateDto
{
    private string $entityName;

    private string $entityClass;

    private ClassGenerator $generator;

    private EntityManagerInterface $entityManager;

    const EXCLUDE = ['isActive', 'createdAt', 'deletedAt', 'updatedAt', 'uuid'];

    private $path;

    const USES = [
        'App\Core\%1$s\Command\Update%1$sCommand\Update%1$sCommand',
        'Symfony\Component\HttpFoundation\Request'
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
        $this->generator->setName(sprintf('Update%1$sRequestDto', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\Dto\Controller\Api\Admin\%1$s', $this->entityName));

        foreach(self::USES as $use){
            $this->generator->addUse(sprintf($use, $this->entityName));
        }

        $entityProperties = $this->entityManager->getClassMetadata($this->entityClass)->fieldMappings;
        $createMethodBody = '';
        $populateMethodBody = '';
        foreach ($entityProperties as $mapping) {
            if (in_array($mapping['fieldName'], self::EXCLUDE)) {
                continue;
            }

            $fieldNameUpper = ucwords($mapping['fieldName']);

            $property = new PropertyGenerator();
            $property->setName($mapping['fieldName']);
            $property->setFlags(PropertyGenerator::FLAG_PRIVATE);
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

            $createMethodBody .= <<<BODY
\$dto->{$mapping['fieldName']} = \$data['$mapping[fieldName]'] ?? null;\n
BODY;
            $populateMethodBody .= <<<BODY
\$command->set{$fieldNameUpper}(\$this->$mapping[fieldName]);\n
BODY;

        }

        $parameter = new ParameterGenerator('request', 'Request');
        $createMethod = new MethodGenerator('createFromRequest', [
            $parameter
        ]);
        $createMethod->setReturnType('self');
        $createMethod->setStatic(true);

        $createMethod->setBody(<<<BODY
\$dto = new self();
\$data = json_decode(\$request->getContent(), true);

$createMethodBody

return \$dto;
BODY
);

        $this->generator->addMethodFromGenerator($createMethod);

        $populateMethod = new MethodGenerator('populateCommand', [
            new ParameterGenerator('command', sprintf('Update%1$sCommand', $this->entityName))
        ]);
        $populateMethod->setBody(<<<BODY
$populateMethodBody
BODY
);
        $this->generator->addMethodFromGenerator($populateMethod);

        file_put_contents(sprintf('%2$s/Update%1$sRequestDto.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }
}