<?php 

namespace App\Core\Department\Command\DeleteDepartmentCommand;

class DeleteDepartmentCommand
{
    /**
     * @var null|int
     */
    private $id = null;

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
