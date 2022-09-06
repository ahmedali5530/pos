<?php 

namespace App\Core\Device\Command\DeleteDeviceCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Device;

class DeleteDeviceCommandHandler extends EntityManager implements DeleteDeviceCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteDeviceCommand $command) : DeleteDeviceCommandResult
    {
        /** @var Device $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteDeviceCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteDeviceCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Device::class;
    }
}
