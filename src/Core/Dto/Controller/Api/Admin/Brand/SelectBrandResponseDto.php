<?php

namespace App\Core\Dto\Controller\Api\Admin\Brand;

use App\Core\Dto\Common\Brand\BrandDto;
use App\Entity\Brand;

class SelectBrandResponseDto
{
    /**
     * @var BrandDto
     */
    private $brand = null;

    public static function createFromBrand(Brand $brand) : self
    {
        $dto = new self();

        $dto->brand = BrandDto::createFromBrand($brand);

        return $dto;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getBrand()
    {
        return $this->brand;
    }
}
