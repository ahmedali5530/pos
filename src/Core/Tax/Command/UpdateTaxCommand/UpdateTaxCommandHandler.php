<?php 

namespace App\Core\Tax\Command\UpdateTaxCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Tax;

class UpdateTaxCommandHandler extends EntityManager implements UpdateTaxCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateTaxCommand $command) : UpdateTaxCommandResult
    {
        /** @var Tax $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateTaxCommandResult::createNotFound();
        }

        if($command->getName() !== null){
            $item->setName($command->getName());
        }
        if($command->getRate() !== null){
            $item->setRate($command->getRate());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateTaxCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateTaxCommandResult();
        $result->setTax($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Tax::class;
    }
}
