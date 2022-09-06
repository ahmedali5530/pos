<?php 

namespace App\Core\Device\Command\UpdateDeviceCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Device;

class UpdateDeviceCommandHandler extends EntityManager implements UpdateDeviceCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateDeviceCommand $command) : UpdateDeviceCommandResult
    {
        /** @var Device $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateDeviceCommandResult::createNotFound();
        }

        if($command->getIpAddress() !== null){
            $item->setIpAddress($command->getIpAddress());
        }
        if($command->getPort() !== null){
            $item->setPort($command->getPort());
        }
        if($command->getName() !== null){
            $item->setName($command->getName());
        }
        if($command->getPrints() !== null){
            $item->setPrints($command->getPrints());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateDeviceCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateDeviceCommandResult();
        $result->setDevice($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Device::class;
    }
}
