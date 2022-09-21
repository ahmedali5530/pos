<?php

namespace App\Core\Dto\Controller\Api\Admin\Tax;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Tax\Command\CreateTaxCommand\CreateTaxCommand;

class CreateTaxRequestDto
{
    use StoresRequestDtoTrait;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $name = null;

    /**
     * @var null|float
     * @Assert\NotBlank(normalizer="trim")
     */
    private $rate = null;

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

        $dto->name = $data['name'] ?? null;
        $dto->rate = $data['rate'] ?? null;
        $dto->stores = $data['stores'] ?? null;


        return $dto;
    }

    public function populateCommand(CreateTaxCommand $command)
    {
        $command->setName($this->name);
        $command->setRate($this->rate);
        $command->setStores($this->stores);
    }
}
