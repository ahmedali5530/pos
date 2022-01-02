<?php

namespace App\Command;

use App\Core\Product\Query\GetProductsListQuery\GetProductsListQueryResult;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MakeQueryCommand extends Command
{
    protected static $defaultName = 'app:make:query';
    protected static $defaultDescription = 'Create query query for Core CQRS';

    private $container;

    public function __construct(string $name = null, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    protected function configure(): void
    {
        $this
            ->addOption('folder', 'folder', InputOption::VALUE_REQUIRED, 'What is the name of folder')
            ->addOption('query', 'query', InputOption::VALUE_REQUIRED, 'What is the query for')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $folder = $input->getOption('folder');
        $query = $input->getOption('query');
        if(strpos($query, 'Query') === false){
            $query .= 'Query';
        }

        $path = sprintf('%s/src/Core/%s/Query/%s',$this->container->getParameter('PROJECT_DIR'), $folder, $query);
        if(file_exists($path)){
            $io->error('Query "'.$query.'" already exists');
            return Command::FAILURE;
        }

        mkdir($path, 0777, true);

        //create command
        file_put_contents($path . '/'.$query.'.php', $this->getQueryMarkup($folder, $query));
        //create query result
        file_put_contents($path . '/'.$query.'Result.php', $this->getQueryResultMarkup($folder, $query));
        //create query handler interface
        file_put_contents($path . '/'.$query.'HandlerInterface.php', $this->getQueryHandlerInterfaceMarkup($folder, $query));
        //create query handler
        file_put_contents($path . '/'.$query.'Handler.php', $this->getQueryHandlerMarkup($folder, $query));

        $io->success('Query "'.$query.'" Created');

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

class {$query}Result
{
    private array \$list = [];

    private int \$count = 0;

    private int \$total = 0;
    
    public function getList(): array
    {
        return \$this->list;
    }
    
    public function setList(array \$list): void
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

    private function getQueryHandlerMarkup($folder, $query)
    {
        return <<<CommandHandler
<?php

namespace App\Core\\$folder\Query\\$query;

use App\Core\Entity\Repository\EntityRepository;

class {$query}Handler extends EntityRepository implements {$query}HandlerInterface
{
    protected function getEntityClass(): string
    {
        return $folder::class;
    }
    
    public function handle($query \$query): {$query}Result
    {
        //TODO: customize this method to return proper data
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
        
        \$list = \$qb->getQuery()->getResult();

        \$result = new {$query}Result();
        \$result->setList(\$list);
        return \$result;
    }
}
CommandHandler;
    }
}
