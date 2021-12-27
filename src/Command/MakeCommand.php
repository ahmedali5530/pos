<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MakeCommand extends Command
{

    protected static $defaultName = 'app:make:command';
    protected static $defaultDescription = 'Create command for Core CQRS';

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
            ->addOption('command', 'command', InputOption::VALUE_REQUIRED, 'What is the command for')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $folder = $input->getOption('folder');
        $command = $input->getOption('command');
        if(strpos($command, 'Command') === false){
            $command .= 'Command';
        }

        $path = sprintf('%s/src/Core/%s/Command/%s',$this->container->getParameter('PROJECT_DIR'), $folder, $command);
        if(file_exists($path)){
            $io->error('Command "'.$command.'" already exists');
            return Command::FAILURE;
        }

        mkdir($path, 0777, true);

        //create command
        file_put_contents($path . '/'.$command.'.php', $this->getCommandMarkup($folder, $command));
        //create command result
        file_put_contents($path . '/'.$command.'Result.php', $this->getCommandResultMarkup($folder, $command));
        //create command handler interface
        file_put_contents($path . '/'.$command.'HandlerInterface.php', $this->getCommandHandlerInterfaceMarkup($folder, $command));
        //create command handler
        file_put_contents($path . '/'.$command.'Handler.php', $this->getCommandHandlerMarkup($folder, $command));


        $io->success('Command "'.$command.'" Created');

        return Command::SUCCESS;
    }

    private function getCommandMarkup($folder, $command)
    {
        return <<<Command
<?php

namespace App\Core\\$folder\Command\\$command;

class $command
{
    
}
Command;
    }

    private function getCommandResultMarkup($folder, $command)
    {
        return <<<CommandResult
<?php

namespace App\Core\\$folder\Command\\$command;

class {$command}Result
{
    
}
CommandResult;
    }

    private function getCommandHandlerInterfaceMarkup($folder, $command)
    {
        return <<<CommandHandlerInterface
<?php

namespace App\Core\\$folder\Command\\$command;

interface {$command}HandlerInterface
{
    public function handle($command \$command): {$command}Result;
}
CommandHandlerInterface;
    }

    private function getCommandHandlerMarkup($folder, $command)
    {
        return <<<CommandHandler
<?php

namespace App\Core\\$folder\Command\\$command;

use App\Core\Entity\EntityManager\EntityManager;

class {$command}Handler extends EntityManager implements {$command}HandlerInterface
{
    protected function getEntityClass(): string
    {
        //TODO: return Entity class
        return '';
    }
    
    public function handle($command \$command): {$command}Result
    {
        
    }
}
CommandHandler;
    }


}