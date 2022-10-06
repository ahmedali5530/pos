<?php

namespace App\Core\Dto\Common\Terminal;

use App\Core\Dto\Common\Common\ActiveDtoTrait;
use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\DescriptionDtoTrait;
use App\Core\Dto\Common\Common\IdDtoTrait;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
use App\Core\Dto\Common\Product\ProductDto;
use App\Core\Dto\Common\Product\ProductShortDto;
use App\Core\Dto\Common\Store\StoreDto;
use App\Entity\Terminal;

class TerminalShortDto extends TerminalDto
{


    public static function createFromTerminal(?Terminal $terminal): ?self
    {
        if($terminal === null){
            return null;
        }

        $dto = new self();

        $dto->setId($terminal->getId());
        $dto->setCode($terminal->getCode());
        $dto->setDescription($terminal->getDescription());
        $dto->setIsActive($terminal->getIsActive());
        $dto->setUuid($terminal->getUuid());
        $dto->setCreatedAt(DateTimeDto::createFromDateTime($terminal->getCreatedAt()));
        $dto->setUpdatedAt(DateTimeDto::createFromDateTime($terminal->getUpdatedAt()));

        return $dto;
    }
}
