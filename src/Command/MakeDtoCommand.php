<?php

namespace App\Command;

use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;
use Laminas\Code\Reflection\ClassReflection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeDtoCommand extends Command
{
    protected static $defaultName = 'app:make:dto';
    protected static $defaultDescription = 'Create dto bodies for request (get, post, body) and generate populate query or command';

    protected function configure(): void
    {
//        $this
//            ->addOption('query', 'k', InputOption::VALUE_OPTIONAL, 'generate populate query')
//            ->addOption('command', 'c', InputOption::VALUE_OPTIONAL, 'generate populate command')
//        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $dtoTypeQuestion = new Question('what is the populate type: ', 'command');
        $dtoTypeQuestion->setAutocompleterValues(['command', 'query']);

        $dtoType = $helper->ask($input, $output, $dtoTypeQuestion);

        $requestTypeQuestion = new Question('what is the request type: ', 'json');
        $requestTypeQuestion->setAutocompleterValues(['json', 'post', 'get']);

        $requestType = $helper->ask($input, $output, $requestTypeQuestion);

        $folderQuestion = new Question('Please enter the fully qualified class name: ');
        $class = $helper->ask($input, $output, $folderQuestion);

        if(!class_exists($class)){
            $io->error("$class not found");
            return Command::FAILURE;
        }

        $properties = new \ReflectionClass($class);



        $this->updateClass($class, $requestType, $properties, $dtoType);

        $io->success('Generated dto');

        return Command::SUCCESS;
    }

    private function updateClass($class, $requestType = 'json', \ReflectionClass $properties = null, $populate = null): void
    {
        $generator = ClassGenerator::fromReflection(
            new ClassReflection($class)
        );

        $props = <<<CODE
\$dto = new self();\n

CODE;

        if($requestType === 'json'){
            $props .= <<<CODE
            \$data = json_decode(\$request->getContent(), true);\n
CODE;
            foreach($properties->getProperties() as $property){
                $props .= <<<CODE
\$dto->$property->name = \$data['$property->name'] ?? null;\n
CODE;
            }
        }

        if($requestType === 'post'){
            foreach($properties->getProperties() as $property){
                $props .= <<<CODE
\$dto->$property->name = \$request->request->get('$property->name');\n
CODE;
            }
        }

        if($requestType === 'get'){
            foreach($properties->getProperties() as $property){
                $props .= <<<CODE
\$dto->$property->name = \$request->query->get('$property->name');\n
CODE;
            }
        }

        $props .= <<<CODE

return \$dto;
CODE;
        $generator->addMethod(
            'createFromRequest',
            [new ParameterGenerator(
                'request', 'Request'
            )],
            [MethodGenerator::FLAG_STATIC, MethodGenerator::FLAG_PUBLIC],
            $props
        );

        if($populate === 'command'){
            $props = '';
            foreach($properties->getProperties() as $property){
                $propertyUpper = ucfirst($property->name);

                $props .= <<<CODE
\$command->set$propertyUpper(\$this->$property->name);\n
CODE;
            }
            $generator->addMethod(
                'populateCommand',
                ['command'],
                [MethodGenerator::FLAG_PUBLIC],
                $props
            );
        }else if($populate === 'query'){
            $props = '';
            foreach($properties->getProperties() as $property){
                $propertyUpper = ucfirst($property->name);

                $props .= <<<CODE
\$query->set$propertyUpper(\$this->$property->name);\n
CODE;
            }
            $generator->addMethod(
                'populateQuery',
                ['query'],
                [MethodGenerator::FLAG_PUBLIC],
                $props
            );
        }

        $code = $generator->generate();

        file_put_contents($properties->getFileName(), "<?php \n\n".$code);
    }
}
