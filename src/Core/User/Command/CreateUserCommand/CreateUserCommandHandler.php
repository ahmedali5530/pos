<?php

namespace App\Core\User\Command\CreateUserCommand;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;

class CreateUserCommandHandler extends EntityManager implements CreateUserCommandHandlerInterface
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

    public function handle(CreateUserCommand $command) : CreateUserCommandResult
    {
        $item = new User();

        $item->setUsername($command->getUsername());
        $item->setSalt(Uuid::uuid4());
        $item->setPassword(
            $this->passwordHasher->hashPassword($item, $command->getPassword())
        );
        $item->setDisplayName($command->getDisplayName());
        $item->setVerificationToken(base64_encode(Uuid::uuid4().random_bytes(64).Uuid::uuid4()));
        $item->setRoles($command->getRoles());
        $item->setEmail($command->getEmail());

        if($command->getStores() !== null){
            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);

                $item->addStore($s);
            }
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateUserCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateUserCommandResult();
        $result->setUser($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return User::class;
    }
}
