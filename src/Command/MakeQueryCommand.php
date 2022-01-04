<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MakeQueryCommand extends Command
{
    protected static $defaultName = 'app:make:query';
    protected static $defaultDescription = 'Create query query for Core CQRS';

    private $container;

    private $entityManager;

    public function __construct(
        ContainerInterface $container,
        EntityManagerInterface $entityManager,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $folderQuestion = new Question('Please enter the name of the folder when your command will be inserted: ');
        $folder = $helper->ask($input, $output, $folderQuestion);

        $queryQuestion = new Question('What is the query name: ');
        $query = $helper->ask($input, $output, $queryQuestion);

        if(strpos($query, 'Query') === false){
            $query .= 'Query';
        }

        $classes = $this->entityManager->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();

        $entities = [];
        foreach($classes as $class){
            $entities[] = str_replace('App\\Entity\\', '', $class);
        }
        $question = new Question('Please enter the name of entity: ');
        $question->setAutocompleterValues($entities);


        $entity = $helper->ask($input, $output, $question);

        $entityWithNamespace = 'App\\Entity\\' . $entity;
        $entityMetadata = $this->entityManager->getClassMetadata($entityWithNamespace)->getFieldNames();

        $path = sprintf('%s/src/Core/%s/Query/%s', $this->container->getParameter('PROJECT_DIR'), $folder, $query);
        if (file_exists($path)) {
            $io->error('Query "' . $query . '" already exists');
            return Command::FAILURE;
        }

        mkdir($path, 0777, true);

        //create command
        file_put_contents($path . '/' . $query . '.php', $this->getQueryMarkup($folder, $query));
        //create query result
        file_put_contents($path . '/' . $query . 'Result.php', $this->getQueryResultMarkup($folder, $query));
        //create query handler interface
        file_put_contents($path . '/' . $query . 'HandlerInterface.php', $this->getQueryHandlerInterfaceMarkup($folder, $query));
        //create query handler
        file_put_contents($path . '/' . $query . 'Handler.php', $this->getQueryHandlerMarkup($folder, $query, $entity));

        $io->success('Query "' . $query . '" Created');

        return Command::SUCCESS;
    }

    private function getQueryMarkup($folder, $query)
    {
        return <<<Command
<?php

namespace App\Core\\$folder\Query\\$query;

class $query
{
    /**
     * @var string|null
     */
    private \$q;

    /**
     * @var int|null
     */
    private \$limit;

    /**
     * @var int|null
     */
    private \$offset;

    /**
     * @return string|null
     */
    public function getQ(): ?string
    {
        return \$this->q;
    }

    public function setQ(?string \$q): void
    {
        \$this->q = \$q;
    }

    public function getLimit(): ?int
    {
        return \$this->limit;
    }

    public function setLimit(?int \$limit): void
    {
        \$this->limit = \$limit;
    }

    public function getOffset(): ?int
    {
        return \$this->offset;
    }

    public function setOffset(?int \$offset): void
    {
        \$this->offset = \$offset;
    }
}
Command;
    }

    private function getQueryResultMarkup($folder, $query)
    {
        return <<<CommandResult
<?php

namespace App\Core\\$folder\Query\\$query;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class {$query}Result
{
    use CqrsResultEntityNotFoundTrait;
    use CqrsResultValidationTrait;
    
    private iterable \$list = [];

    private int \$count = 0;

    private int \$total = 0;
    
    public function getList(): iterable
    {
        return \$this->list;
    }
    
    public function setList(iterable \$list): void
    {
        \$this->list = \$list;
    }
    
    public function getCount(): int
    {
        return \$this->count;
    }
    
    public function setCount(int \$count): void
    {
        \$this->count = \$count;
    }

    public function getTotal(): int
    {
        return \$this->total;
    }

    public function setTotal(int \$total): void
    {
        \$this->total = \$total;
    }
}
CommandResult;
    }

    private function getQueryHandlerInterfaceMarkup($folder, $query)
    {
        return <<<CommandHandlerInterface
<?php

namespace App\Core\\$folder\Query\\$query;

interface {$query}HandlerInterface
{
    public function handle($query \$query): {$query}Result;
}
CommandHandlerInterface;
    }

    private function getQueryHandlerMarkup($folder, $query, $entity)
    {
        return <<<CommandHandler
<?php

namespace App\Core\\$folder\Query\\$query;

use App\Core\Entity\Repository\EntityRepository;
use App\Entity\\$entity;
use Doctrine\ORM\Tools\Pagination\Paginator;

class {$query}Handler extends EntityRepository implements {$query}HandlerInterface
{
    protected function getEntityClass(): string
    {
        return $entity::class;
    }
    
    public function handle($query \$query): {$query}Result
    {
        \$qb = \$this->createQueryBuilder('entity');
        
        if(\$query->getQ() !== null){
            \$qb->andWhere('entity. = :q');
            \$qb->setParameter('q', \$query->getQ());
        }
        
        if(\$query->getLimit() !== null){
            \$qb->setMaxResults(\$query->getLimit());
        }
        
        if(\$query->getOffset() !== null){
            \$qb->setFirstResult(\$query->getOffset());
        }
        
        \$list = new Paginator(\$qb->getQuery());

        \$result = new {$query}Result();
        \$result->setList(\$list);
        \$result->setTotal(\$list->count());
        \$result->setCount(count(\$list));
        return \$result;
    }
}
CommandHandler;
    }
}
