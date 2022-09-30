<?php

namespace App\Core\Dto\Controller\Api\Admin\Department;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Department\Command\CreateDepartmentCommand\CreateDepartmentCommand;

class CreateDepartmentRequestDto
{
    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $name = null;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $description = null;

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

        $dto->name = $data['name'] ?? null;
        $dto->description = $data['description'] ?? null;


        return $dto;
    }

    public function populateCommand(CreateDepartmentCommand $command)
    {
        $command->setName($this->name);
        $command->setDescription($this->description);
    }
}
