<?php 

namespace App\Core\Brand\Command\CreateBrandCommand;

class CreateBrandCommand
{
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
