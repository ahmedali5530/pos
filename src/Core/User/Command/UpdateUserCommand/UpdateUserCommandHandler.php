<?php

namespace App\Core\User\Command\UpdateUserCommand;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;

class UpdateUserCommandHandler extends EntityManager implements UpdateUserCommandHandlerInterface
{
    public $validator = null;

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(
        EntityManagerInterface $entityManager, ValidatorInterface $validator,
        UserPasswordHasherInterface $passwordHasher
    )
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
        $this->passwordHasher = $passwordHasher;
    }

    public function handle(UpdateUserCommand $command) : UpdateUserCommandResult
    {
        /** @var User $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateUserCommandResult::createNotFound();
        }

        if($command->getUsername() !== null){
            $item->setUsername($command->getUsername());
        }

        if($command->getPassword() !== null) {
            $item->setSalt(Uuid::uuid4());
            $item->setPassword(
                $this->passwordHasher->hashPassword($item, $command->getPassword())
            );
        }

        if($command->getDisplayName() !== null){
            $item->setDisplayName($command->getDisplayName());
        }
        if($command->getRoles() !== null){
            $item->setRoles($command->getRoles());
        }
        if($command->getEmail() !== null){
            $item->setEmail($command->getEmail());
        }

        if($command->getStores() !== null){
            //remove all stores first
            foreach($item->getStores() as $store){
                $item->removeStore($store);
            }

            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);

                $item->addStore($s);
            }
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateUserCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateUserCommandResult();
        $result->setUser($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return User::class;
    }
}
