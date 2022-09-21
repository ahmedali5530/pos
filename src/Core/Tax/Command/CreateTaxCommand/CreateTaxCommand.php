<?php

namespace App\Core\Tax\Command\CreateTaxCommand;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;

class CreateTaxCommand
{
    use StoresRequestDtoTrait;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|float
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
}
