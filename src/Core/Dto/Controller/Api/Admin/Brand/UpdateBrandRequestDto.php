<?php

namespace App\Core\Dto\Controller\Api\Admin\Brand;

use App\Core\Brand\Command\UpdateBrandCommand\UpdateBrandCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateBrandRequestDto
{
    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $name = null;

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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateBrandCommand $command)
    {
        $command->setId($this->id);
        $command->setName($this->name);
    }
}
