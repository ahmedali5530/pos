<?php

namespace App\Core\Brand\Command\CreateBrandCommand;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;

class CreateBrandCommand
{
    use StoresRequestDtoTrait;

    /**
     * @var null|string
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
}
