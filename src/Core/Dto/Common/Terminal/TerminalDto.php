<?php

namespace App\Core\Dto\Common\Terminal;

use App\Core\Dto\Common\Common\ActiveDtoTrait;
use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\DescriptionDtoTrait;
use App\Core\Dto\Common\Common\IdDtoTrait;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
use App\Entity\Terminal;

class TerminalDto
{
    use IdDtoTrait, DescriptionDtoTrait, ActiveDtoTrait, UuidDtoTrait,
        TimestampsDtoTrait;

    /**
     * @var string
     */
    private $code;

    public static function createFromTerminal(?Terminal $terminal): ?self
    {
        if($terminal === null){
            return null;
        }

        $dto = new self();

        $dto->id = $terminal->getId();
        $dto->code = $terminal->getCode();
        $dto->description = $terminal->getDescription();
        $dto->isActive = $terminal->getIsActive();
        $dto->uuid = $terminal->getUuid();
        $dto->createdAt = DateTimeDto::createFromDateTime($terminal->getCreatedAt());
        $dto->updatedAt = DateTimeDto::createFromDateTime($terminal->getUpdatedAt());

        return $dto;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}
