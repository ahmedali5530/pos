<?php


namespace App\Command\Crud\Select;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;

class SelectQueryHandler
{
    private string $entityName;

    private string $entityClass;

    private ClassGenerator $generator;

    private EntityManagerInterface $entityManager;

    const EXCLUDE = ['deletedAt', 'updatedAt', 'uuid', 'createdAt'];

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
        'handle' => ['query' => 'Select{entityName}Query']
    ];

    const CLASS_PROPERTIES = [
        'validator'
    ];

    const USES = [
        'App\Entity\{entityName}',
        'Doctrine\ORM\Tools\Pagination\Paginator',
        'App\Core\Entity\Repository\EntityRepository',
        'Doctrine\ORM\EntityManagerInterface',
        'Symfony\Component\Validator\Validator\ValidatorInterface'
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

        $this->generator->setExtendedClass('EntityRepository');
        $this->generator->setImplementedInterfaces([
            sprintf('Select%1$sQueryHandlerInterface', $this->entityName)
        ]);
        $this->generator->setName(sprintf('Select%sQueryHandler', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\%1$s\Query\Select%1$sQuery', $this->entityName));

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
        $likeCondition = [];
        foreach ($entityProperties as $mapping) {
            if (in_array($mapping['fieldName'], self::EXCLUDE)) {
                continue;
            }

            $fieldName = ucwords($mapping['fieldName']);
            $operator = '=';
            $queryParameter = '$query->get'.$fieldName.'()';
            if($this->getPhpType($mapping['type']) === '?string'){
                $operator = 'LIKE';
                $queryParameter = "'%'.$fieldName.'%'";

                $likeCondition[] = $fieldName.' LIKE :q';
            }


            $fields .= <<<FIELD
if(\$query->get{$fieldName}() !== null){
    \$qb->andWhere('{$this->entityName}.{$mapping['fieldName']} $operator :{$mapping['fieldName']}');
    \$qb->setParameter('{$mapping['fieldName']}', $queryParameter);
}
FIELD;
        }

        $likeCondition = implode('OR', $likeCondition);

        $this->generator->getMethod('handle')->setBody(<<<BODY
\$qb = \$this->createQueryBuilder('{$this->entityName}');

$fields

if(\$query->getQ() !== null){
    \$qb->andWhere('$likeCondition');
    \$qb->setParameter('q', '%'.\$query->getQ().'%');
}

if(\$query->getLimit() !== null){
    \$qb->setMaxResults(\$query->getLimit());
}

if(\$query->getOffset() !== null){
    \$qb->setFirstResult(\$query->getOffset());
}

if(\$query->getOrderBy() !== null){
    \$qb->orderBy(\$query->getOrderBy(), \$query->getOrderMode());
}

\$list = new Paginator(\$qb->getQuery());

\$result = new Select{$this->entityName}QueryResult();
\$result->setList(\$list);
\$result->setCount(count(\$list));
\$result->setTotal(\$list->count());

return \$result;
BODY
        )->setReturnType(sprintf('Select%1$sQueryResult', $this->entityName));

        $this->generator->getMethod('getEntityClass')
            ->setVisibility(MethodGenerator::VISIBILITY_PROTECTED)
            ->setReturnType('string');

        file_put_contents(sprintf('%2$s/Select%1$sQueryHandler.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }

    protected function replace($subject)
    {
        return str_replace('{entityName}', $this->entityName, $subject);
    }
}
