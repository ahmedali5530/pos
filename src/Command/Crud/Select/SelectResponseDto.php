<?php


namespace App\Command\Crud\Select;


use App\Command\Crud\GenerateCrud;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\GenericTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;
use Laminas\Code\Generator\PropertyGenerator;
use PhpParser\Comment\Doc;

class SelectResponseDto
{
    private string $entityName;

    private string $entityClass;

    private ClassGenerator $generator;

    private EntityManagerInterface $entityManager;

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
        $this->generator->setName(sprintf('Select%1$sResponseDto', $this->entityName));
        $this->generator->setNamespaceName(sprintf('App\Core\Dto\Controller\Api\Admin\%1$s', $this->entityName));
        $this->generator->addUse(sprintf('App\Core\Dto\Common\%1$s\%1$sDto', $this->entityName));
        $this->generator->addUse(sprintf('App\Entity\%s', $this->entityName));

        $lowerProperty = lcfirst($this->entityName);
        $parameter = new ParameterGenerator(lcfirst($this->entityName), $this->entityName);
        $createMethod = new MethodGenerator(sprintf('createFrom%s', $this->entityName), [
            $parameter
        ]);
        $createMethod->setReturnType('self');
        $createMethod->setStatic(true);

        $createMethod->setBody(<<<BODY
\$dto = new self();

\$dto->{$lowerProperty} = {$this->entityName}Dto::createFrom{$this->entityName}(\${$lowerProperty});

return \$dto;
BODY
        );

        $this->generator->addMethodFromGenerator($createMethod);

        $methods = [
            $lowerProperty
        ];
        foreach($methods as $method){
            $property = new PropertyGenerator($method, null, PropertyGenerator::FLAG_PRIVATE);
            $property->setDocBlock('@var '.sprintf('%sDto', $this->entityName));
            $this->generator->addPropertyFromGenerator($property);

            $this->generator->addMethod('set'.ucwords($method), [
                new ParameterGenerator($method)
            ], MethodGenerator::FLAG_PUBLIC, <<<BODY
\$this->{$method} = \${$method};
BODY
            );
            $this->generator->addMethod('get' . ucwords($method), [], MethodGenerator::FLAG_PUBLIC, <<<BODY
return \$this->{$method};
BODY
            );
        }

        file_put_contents(sprintf('%2$s/Select%1$sResponseDto.php', $this->entityName, $this->path), "<?php \n\n" . $this->generator->generate());
    }
}