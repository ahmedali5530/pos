<?php

namespace App\Core\Dto\Controller\Api\Admin\Department;

use App\Core\Dto\Common\Department\DepartmentDto;
use App\Entity\Department;

class SelectDepartmentResponseDto
{
    /**
     * @var DepartmentDto
     */
    private $department = null;

    public static function createFromDepartment(Department $department) : self
    {
        $dto = new self();

        $dto->department = DepartmentDto::createFromDepartment($department);

        return $dto;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function getDepartment()
    {
        return $this->department;
    }
}
