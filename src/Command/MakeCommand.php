<?php

namespace App\Command;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MakeCommand extends Command
{

    protected static $defaultName = 'app:make:command';
    protected static $defaultDescription = 'Create command for Core CQRS';

    private $container;

    private $entityManager;

    protected $exclude = ['id', 'isActive', 'createdAt', 'deletedAt', 'updatedAt', 'uuid'];

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
        $this
            ->addOption('create', 'c')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $isCreate = $input->getOption('create');

        $folderQuestion = new Question('Please enter the name of the folder when your command will be inserted: ');
        $folder = $helper->ask($input, $output, $folderQuestion);

        $commandQuestion = new Question('What is the command name: ');
        $command = $helper->ask($input, $output, $commandQuestion);

        if(strpos($command, 'Command') === false){
            $command .= 'Command';
        }

        $path = sprintf('%s/src/Core/%s/Command/%s',$this->container->getParameter('PROJECT_DIR'), $folder, $command);
        if(file_exists($path)){
            $io->error('Command "'.$command.'" already exists');
            return Command::FAILURE;
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

        mkdir($path, 0777, true);

        // create command
        file_put_contents($path . '/'.$command.'.php', $this->getCommandMarkup($folder, $command, $entityMetadata, $isCreate));
        // create command result
        file_put_contents($path . '/'.$command.'Result.php', $this->getCommandResultMarkup($folder, $command, $entity, $entityWithNamespace));
        // create command handler interface
        file_put_contents($path . '/'.$command.'HandlerInterface.php', $this->getCommandHandlerInterfaceMarkup($folder, $command));
        // create command handler
        file_put_contents($path . '/'.$command.'Handler.php', $this->getCommandHandlerMarkup($folder, $command, $entityMetadata, $entity, $entityWithNamespace, $isCreate));


        $io->success('Command "'.$command.'" Created');

        return Command::SUCCESS;
    }

    private function getCommandMarkup($folder, $command, $entityFields, $isCreate = false)
    {
        $fields = $this->_getEntityFields($entityFields, $isCreate);
        return <<<Command
<?php

namespace App\Core\\$folder\Command\\$command;

class $command
{
    $fields
}
Command;
    }

    private function getCommandResultMarkup($folder, $command, $entity, $entityWithNamespace)
    {
        $entityUpper = ucfirst($entity);
        $entity = lcfirst($entity);

        return <<<CommandResult
<?php

namespace App\Core\\$folder\Command\\$command;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;
use $entityWithNamespace;

class {$command}Result
{
    use CqrsResultEntityNotFoundTrait;
    use CqrsResultValidationTrait;
    
    private $entityUpper \${$entity};
    
    public function set$entityUpper($entityUpper \${$entity}): self
    {
        \$this->$entity = \${$entity};
        return \$this;
    }
    
    public function get$entityUpper(): $entityUpper
    {
        return \$this->$entity;
    }
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

    private function getCommandHandlerMarkup($folder, $command, $fields, $entity, $entityWithNamespace, $isCreate = false)
    {
        $handle = '';
        if($isCreate){
            $handle = $this->_createEntityCommand($entity, $fields);
        }else{
            $handle = $this->_updateEntityCommand($entity, $fields, $command);
        }

        $entityUpper = ucfirst($entity);
        $entity = lcfirst($entity);

        return <<<CommandHandler
<?php

namespace App\Core\\$folder\Command\\$command;

use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use $entityWithNamespace;

class {$command}Handler extends EntityManager implements {$command}HandlerInterface
{
    protected function getEntityClass(): string
    {
        return {$entityUpper}::class;
    }
    
    private \$validator;

    public function __construct(
        EntityManagerInterface \$entityManager,
        ValidatorInterface \$validator
    )
    {
        parent::__construct(\$entityManager);
        \$this->validator = \$validator;
    }
    
    public function handle($command \$command): {$command}Result
    {
        $handle
        
        //validate item before creation
        \$violations = \$this->validator->validate(\$item);
        if(\$violations->count() > 0){
            return {$command}Result::createFromConstraintViolations(\$violations);
        }
        
        \$this->persist(\$item);
        \$this->flush();
        
        \$result = new {$command}Result();
        \$result->set$entityUpper(\$item);
        
        return \$result;
    }
}
CommandHandler;
    }

    private function _getEntityFields(array $fields, $isCreate): string
    {
        $exclude = $this->exclude;

        if($isCreate === false){
            array_shift($exclude);
        }

        $string = '';
        foreach($fields as $field){
            if(in_array($field, $exclude)){
                continue;
            }

            $string .= <<<HTML
        private \${$field};\n
HTML;
        }

        foreach($fields as $field){
            if(in_array($field, $exclude)){
                continue;
            }

            $fieldUpper = ucfirst($field);
            $string .= <<<HTML
        public function get$fieldUpper()
        {
            return \$this->$field;
        }
        
        public function set$fieldUpper(\$field)
        {
            \$this->$field = \$field;
            return \$this;
        }
HTML;
        }

        return $string;
    }

    private function _createEntityCommand($entity, $fields): string
    {
        $exclude = $this->exclude;

        $string = <<<HTML
        \$item = new $entity();

HTML;

        foreach($fields as $field){
            if(in_array($field, $exclude)){
                continue;
            }

            $fieldUpper = ucfirst($field);
            $string .= <<<HTML
        \$item->set$fieldUpper(\$command->get$fieldUpper());\n
HTML;
        }

        return $string;
    }

    private function _updateEntityCommand($entity, $fields, $command): string
    {
        $exclude = $this->exclude;

        $string = <<<HTML
        /** @var $entity \$item */
        \$item = \$this->getRepository()->find(\$command->getId());\n
        if(\$item === null){
            return {$command}Result::createNotFound();
        }

HTML;
        foreach($fields as $field){
            if(in_array($field, $exclude)){
                continue;
            }

            $fieldUpper = ucfirst($field);
            $string .= <<<HTML
        if(\$command->get$fieldUpper() !== null){
            \$item->set$fieldUpper(\$command->get$fieldUpper());
        }

HTML;
        }

        return $string;
    }
}