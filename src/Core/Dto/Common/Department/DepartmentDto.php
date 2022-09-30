<?php

namespace App\Core\Dto\Common\Department;

use App\Core\Dto\Common\Common\ActiveDtoTrait;
use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\DescriptionDtoTrait;
use App\Core\Dto\Common\Common\IdDtoTrait;
use App\Core\Dto\Common\Common\NameDtoTrait;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
use App\Entity\Department;

class DepartmentDto
{
    use IdDtoTrait, NameDtoTrait, DescriptionDtoTrait, ActiveDtoTrait, UuidDtoTrait,
        TimestampsDtoTrait;

    public static function createFromDepartment(?Department $department): ?self
    {
        if($department === null){
            return null;
        }

        $dto = new self();

        $dto->id = $department->getId();
        $dto->name = $department->getName();
        $dto->description = $department->getDescription();
        $dto->isActive = $department->getIsActive();
        $dto->uuid = $department->getUuid();
        $dto->createdAt = DateTimeDto::createFromDateTime($department->getCreatedAt());
        $dto->updatedAt = DateTimeDto::createFromDateTime($department->getUpdatedAt());

        return $dto;
    }
}
