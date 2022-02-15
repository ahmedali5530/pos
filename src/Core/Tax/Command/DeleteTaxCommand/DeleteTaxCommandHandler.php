<?php 

namespace App\Core\Tax\Command\DeleteTaxCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Tax;

class DeleteTaxCommandHandler extends EntityManager implements DeleteTaxCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteTaxCommand $command) : DeleteTaxCommandResult
    {
        /** @var Tax $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteTaxCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteTaxCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Tax::class;
    }
}
