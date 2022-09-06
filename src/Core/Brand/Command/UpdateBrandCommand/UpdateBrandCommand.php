<?php 

namespace App\Core\Brand\Command\UpdateBrandCommand;

class UpdateBrandCommand
{
    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $name = null;

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
}
