<?php 

namespace App\Core\Customer\Command\CreatePaymentCommand;

use App\Entity\CustomerPayment;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Customer;

class CreatePaymentCommandHandler extends EntityManager implements CreatePaymentCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreatePaymentCommand $command) : CreatePaymentCommandResult
    {
        $item = new CustomerPayment();
        $item->setDescription($command->getDescription());
        $item->setAmount($command->getAmount());
        if($command->getOrderId() !== null) {
            $item->setOrder($this->getRepository(Order::class)->find($command->getOrderId()));
        }
        $customer = $this->getRepository(Customer::class)->find($command->getCustomerId());
        $item->setCustomer($customer);

        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreatePaymentCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreatePaymentCommandResult();
        $result->setCustomer($customer);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Customer::class;
    }
}
