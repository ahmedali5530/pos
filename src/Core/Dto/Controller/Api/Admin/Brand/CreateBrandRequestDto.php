<?php

namespace App\Core\Dto\Controller\Api\Admin\Brand;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Brand\Command\CreateBrandCommand\CreateBrandCommand;

class CreateBrandRequestDto
{
    use StoresRequestDtoTrait;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $name = null;

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

        $dto->name = $data['name'] ?? null;
        $dto->stores = $data['stores'] ?? null;


        return $dto;
    }

    public function populateCommand(CreateBrandCommand $command)
    {
        $command->setName($this->name);
        $command->setStores($this->stores);
    }
}
