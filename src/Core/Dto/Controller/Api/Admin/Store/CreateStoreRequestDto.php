<?php

namespace App\Core\Dto\Controller\Api\Admin\Store;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Store\Command\CreateStoreCommand\CreateStoreCommand;

class CreateStoreRequestDto
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
    private $location = null;

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

        $dto->name = $data['name'] ?? null;
        $dto->location = $data['location'] ?? null;


        return $dto;
    }

    public function populateCommand(CreateStoreCommand $command)
    {
        $command->setName($this->name);
        $command->setLocation($this->location);
    }
}
