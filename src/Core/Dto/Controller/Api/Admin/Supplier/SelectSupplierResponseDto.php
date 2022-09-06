<?php

namespace App\Core\Dto\Controller\Api\Admin\Supplier;

use App\Core\Dto\Common\Supplier\SupplierDto;
use App\Entity\Supplier;

class SelectSupplierResponseDto
{
    /**
     * @var SupplierDto
     */
    private $supplier = null;

    public static function createFromSupplier(Supplier $supplier) : self
    {
        $dto = new self();

        $dto->supplier = SupplierDto::createFromSupplier($supplier);

        return $dto;
    }

    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    public function getSupplier()
    {
        return $this->supplier;
    }
}
