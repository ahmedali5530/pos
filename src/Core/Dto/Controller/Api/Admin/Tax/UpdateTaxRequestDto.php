<?php

namespace App\Core\Dto\Controller\Api\Admin\Tax;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;
use App\Core\Tax\Command\UpdateTaxCommand\UpdateTaxCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateTaxRequestDto
{
    use StoresRequestDtoTrait;

    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|float
     */
    private $rate = null;

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

    public function setRate(?float $rate)
    {
        $this->rate = $rate;
        return $this;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->rate = $data['rate'] ?? null;
        $dto->stores = $data['stores'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateTaxCommand $command)
    {
        $command->setId($this->id);
        $command->setName($this->name);
        $command->setRate($this->rate);
        $command->setStores($this->stores);
    }
}
