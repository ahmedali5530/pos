<?php 

namespace App\Core\Dto\Controller\Api\Admin\Customer;

use App\Core\Dto\Common\Customer\CustomerDto;
use App\Entity\Customer;

class SelectCustomerResponseDto
{
    /**
     * @var CustomerDto
     */
    private $customer = null;

    public static function createFromCustomer(Customer $customer) : self
    {
        $dto = new self();

        $dto->customer = CustomerDto::createFromCustomer($customer);

        return $dto;
    }

    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer()
    {
        return $this->customer;
    }
}
