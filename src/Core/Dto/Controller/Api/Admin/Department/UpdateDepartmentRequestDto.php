<?php

namespace App\Core\Dto\Controller\Api\Admin\Department;

use App\Core\Department\Command\UpdateDepartmentCommand\UpdateDepartmentCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateDepartmentRequestDto
{
    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|string
     */
    private $description = null;

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->description = $data['description'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateDepartmentCommand $command)
    {
        $command->setId($this->id);
        $command->setName($this->name);
        $command->setDescription($this->description);
    }
}
