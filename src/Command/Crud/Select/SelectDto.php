<?php


namespace App\Command\Crud\Select;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;
use Laminas\Code\Generator\PropertyGenerator;

class SelectDto
{
    private string $entityName;

    private string $entityClass;

    private ClassGenerator $generator;

    private EntityManagerInterface $entityManager;

    const EXCLUDE = ['deletedAt', 'updatedAt', 'uuid', 'createdAt'];

    private $path;

    const USES = [
        'App\Core\%1$s\Query\Select%1$sQuery\Select%1$sQuery',
        'Symfony\Component\HttpFoundation\Request',
        'App\Core\Dto\Common\Common\LimitTrait',
        'App\Core\Dto\Common\Common\OrderTrait',
        'App\Core\Dto\Common\Common\QTrait',
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
        $this->generator->setName(sprintf('Select%1$sRequestDto', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\Dto\Controller\Api\Admin\%1$s', $this->entityName));
        foreach(self::USES as $use){
            $this->generator->addUse(sprintf($use, $this->entityName));
        }

        $entityProperties = $this->entityManager->getClassMetadata($this->entityClass)->fieldMappings;
        $createMethodBody = '';
        $populateMethodBody = '';

        $this->generator->addTraits([
            'LimitTrait', 'OrderTrait', 'QTrait'
        ]);

        $this->generator->addConstant('ORDERS_LIST', [
            'id' => $this->entityName.'.'.'id'
        ]);

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
\$dto->{$mapping['fieldName']} = \$request->query->get('$mapping[fieldName]');\n
BODY;
            $populateMethodBody .= <<<BODY
\$query->set{$fieldNameUpper}(\$this->$mapping[fieldName]);\n
BODY;

        }

        //add sortings to create method
        $createMethodBody .= <<<BODY
\$dto->limit = \$request->query->get('limit');
\$dto->offset = \$request->query->get('offset');
\$dto->orderBy = self::ORDERS_LIST[\$request->query->get('orderBy')] ?? null;
\$dto->orderMode = \$request->query->get('orderMode', 'ASC');
\$dto->q = \$request->query->get('q');
BODY;

        //add sortings to populate method
        $populateMethodBody .= <<<BODY
\$query->setLimit(\$this->getLimit());
\$query->setOffset(\$this->getOffset());
\$query->setOrderBy(\$this->getOrderBy());
\$query->setOrderMode(\$this->getOrderMode());
\$query->setQ(\$this->q);
BODY;

        $parameter = new ParameterGenerator('request', 'Request');
        $createMethod = new MethodGenerator('createFromRequest', [
            $parameter
        ]);
        $createMethod->setReturnType('self');
        $createMethod->setStatic(true);

        $createMethod->setBody(<<<BODY
\$dto = new self();

$createMethodBody

return \$dto;
BODY
);

        $this->generator->addMethodFromGenerator($createMethod);

        $populateMethod = new MethodGenerator('populateQuery', [
            new ParameterGenerator('query', sprintf('Select%1$sQuery', $this->entityName))
        ]);
        $populateMethod->setBody(<<<BODY
$populateMethodBody
BODY
);
        $this->generator->addMethodFromGenerator($populateMethod);

        file_put_contents(sprintf('%2$s/Select%1$sRequestDto.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }
}
