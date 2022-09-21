<?php

namespace App\Core\Category\Command\CreateCategoryCommand;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;

class CreateCategoryCommand
{
    use StoresRequestDtoTrait;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|string
     */
    private $type = null;

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType(?string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
}
