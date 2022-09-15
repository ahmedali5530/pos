<?php 

namespace App\Core\Store\Command\CreateStoreCommand;

class CreateStoreCommand
{
    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|string
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
}
