<?php

namespace App\Core\Dto\Common\Terminal;

use App\Core\Dto\Common\Common\DateTimeDto;
use App\Entity\Terminal;
use App\Core\Dto\Common\Store\StoreShortDto;
use App\Core\Dto\Common\Product\ProductShortDto;

class TerminalShortDto extends TerminalDto
{
    public static function createFromTerminal(?Terminal $terminal): ?self
    {
        if ($terminal === null) {
            return null;
        }

        $dto = new static();

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
