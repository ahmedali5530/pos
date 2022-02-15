<?php 

namespace App\Core\Dto\Controller\Api\Admin\Tax;

use App\Core\Dto\Common\Tax\TaxDto;
use App\Entity\Tax;

class SelectTaxResponseDto
{
    /**
     * @var TaxDto
     */
    private $tax = null;

    public static function createFromTax(Tax $tax) : self
    {
        $dto = new self();

        $dto->tax = TaxDto::createFromTax($tax);

        return $dto;
    }

    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    public function getTax()
    {
        return $this->tax;
    }
}
