<?php

namespace App\Core\Store\Command\DeleteStoreCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Store;

class DeleteStoreCommandHandler extends EntityManager implements DeleteStoreCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteStoreCommand $command) : DeleteStoreCommandResult
    {
        /** @var Store $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteStoreCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteStoreCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Store::class;
    }
}
