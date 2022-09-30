<?php 

namespace App\Core\Department\Command\CreateDepartmentCommand;

class CreateDepartmentCommand
{
    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|string
     */
    private $description = null;

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
