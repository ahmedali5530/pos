<?php

namespace App\Core\Dto\Controller\Api\Admin\Store;

use App\Core\Store\Command\UpdateStoreCommand\UpdateStoreCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateStoreRequestDto
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
    private $location = null;

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

    public function setLocation(?string $location)
    {
        $this->location = $location;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->location = $data['location'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateStoreCommand $command)
    {
        $command->setId($this->id);
        $command->setName($this->name);
        $command->setLocation($this->location);
    }
}
