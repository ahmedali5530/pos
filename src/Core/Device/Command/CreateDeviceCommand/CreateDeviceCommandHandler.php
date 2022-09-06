<?php 

namespace App\Core\Device\Command\CreateDeviceCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Device;

class CreateDeviceCommandHandler extends EntityManager implements CreateDeviceCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateDeviceCommand $command) : CreateDeviceCommandResult
    {
        $item = new Device();

        $item->setIpAddress($command->getIpAddress());
        $item->setPort($command->getPort());
        $item->setName($command->getName());
        $item->setPrints($command->getPrints());


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateDeviceCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateDeviceCommandResult();
        $result->setDevice($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Device::class;
    }
}
