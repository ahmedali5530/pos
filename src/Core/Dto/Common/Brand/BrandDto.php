<?php

namespace App\Core\Dto\Common\Brand;

use App\Core\Dto\Common\Common\IdDtoTrait;
use App\Core\Dto\Common\Common\MediaDto;
use App\Core\Dto\Common\Common\MediaDtoTrait;
use App\Core\Dto\Common\Common\NameDtoTrait;
use App\Entity\Brand;

class BrandDto
{
    use IdDtoTrait, NameDtoTrait, MediaDtoTrait;

    public static function createFromBrand(?Brand $brand): ?self
    {
        if($brand === null){
            return null;
        }

        $dto = new self();

        $dto->id = $brand->getId();
        $dto->name = $brand->getName();
        $dto->media = MediaDto::createFromMedia($brand->getMedia());

        return $dto;
    }
}
