<?php

namespace App\Command;

use App\Command\Crud\Create\CreateCommand;
use App\Command\Crud\Create\CreateCommandHandler;
use App\Command\Crud\Create\CreateCommandHandlerInterface;
use App\Command\Crud\Create\CreateCommandResult;
use App\Command\Crud\Create\CreateDto;
use App\Command\Crud\Select\SelectDto;
use App\Command\Crud\Select\SelectListResponseDto;
use App\Command\Crud\Select\SelectQuery;
use App\Command\Crud\Select\SelectQueryHandler;
use App\Command\Crud\Select\SelectQueryHandlerInterface;
use App\Command\Crud\Select\SelectQueryResult;
use App\Command\Crud\Select\SelectResponseDto;
use App\Command\Crud\Update\UpdateCommand;
use App\Command\Crud\Update\UpdateCommandHandler;
use App\Command\Crud\Update\UpdateCommandHandlerInterface;
use App\Command\Crud\Update\UpdateCommandResult;
use App\Command\Crud\Delete\DeleteCommand;
use App\Command\Crud\Delete\DeleteCommandHandler;
use App\Command\Crud\Delete\DeleteCommandHandlerInterface;
use App\Command\Crud\Delete\DeleteCommandResult;
use App\Command\Crud\GenerateCrud;
use App\Command\Crud\Update\UpdateDto;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\InterfaceGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MakeCrudCommand extends Command
{
    protected static $defaultName = 'app:make:crud';
    protected static $defaultDescription = 'Add a short description for your command';

    private $entityManager;
    private $container;
    public function __construct(
        ContainerInterface $container,
        EntityManagerInterface $entityManager,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $folderQuestion = new Question('Please enter the fully qualified Controller name: ');
        $controllerClass = $helper->ask($input, $output, $folderQuestion);

        if(!class_exists($controllerClass)){
            $io->error("$controllerClass not found");
            return Command::FAILURE;
        }

        $classes = $this->entityManager->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();

        $entities = [];
        foreach ($classes as $class) {
            $entities[] = str_replace('App\\Entity\\', '', $class);
        }
        $question = new Question('Please enter the name of entity: ');
        $question->setAutocompleterValues($entities);

        $entity = $helper->ask($input, $output, $question);

        $entityClass = 'App\\Entity\\' . $entity;

        //create command
        $path = sprintf('%s/src/Core/%s/Command/%s', $this->container->getParameter('PROJECT_DIR'), $entity, 'Create'.$entity.'Command');
        @mkdir($path, 0777, true);

        (new CreateCommand($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new CreateCommandResult($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new CreateCommandHandlerInterface($entity, $entityClass, new InterfaceGenerator(), $this->entityManager, $path))->generate();
        (new CreateCommandHandler($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();

        //update command
        $path = sprintf('%s/src/Core/%s/Command/%s', $this->container->getParameter('PROJECT_DIR'), $entity, 'Update'.$entity.'Command');
        @mkdir($path, 0777, true);

        (new UpdateCommand($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new UpdateCommandResult($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new UpdateCommandHandlerInterface($entity, $entityClass, new InterfaceGenerator(), $this->entityManager, $path))->generate();
        (new UpdateCommandHandler($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();


        //delete command
        $path = sprintf('%s/src/Core/%s/Command/%s', $this->container->getParameter('PROJECT_DIR'), $entity, 'Delete'.$entity.'Command');
        @mkdir($path, 0777, true);

        (new DeleteCommand($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new DeleteCommandResult($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new DeleteCommandHandlerInterface($entity, $entityClass, new InterfaceGenerator(), $this->entityManager, $path))->generate();
        (new DeleteCommandHandler($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();

        //list command
        $path = sprintf('%s/src/Core/%s/Query/%s', $this->container->getParameter('PROJECT_DIR'), $entity, 'Select'.$entity.'Query');
        @mkdir($path, 0777, true);
        (new SelectQuery($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new SelectQueryResult($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new SelectQueryHandlerInterface($entity, $entityClass, new InterfaceGenerator(), $this->entityManager, $path))->generate();
        (new SelectQueryHandler($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();

        //create DTOs
        $path = sprintf('%s/src/Core/Dto/Controller/Api/Admin/%s/', $this->container->getParameter('PROJECT_DIR'), $entity);
        @mkdir($path, 0777, true);
        (new CreateDto($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new UpdateDto($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new SelectDto($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new SelectListResponseDto($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();
        (new SelectResponseDto($entity, $entityClass, new ClassGenerator(), $this->entityManager, $path))->generate();

        //create CRUD controller
        $path = sprintf('%s/src/Controller/Api/Admin/', $this->container->getParameter('PROJECT_DIR'));
        @mkdir($path, 0777, true);
        (new GenerateCrud(new ClassGenerator(), $controllerClass, $entityClass, $entity, $path))->generate();

        $io->success('Crud generated!');

        return Command::SUCCESS;
    }
}
