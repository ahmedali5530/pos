<?php 

namespace App\Core\Supplier\Command\DeleteSupplierCommand;

class DeleteSupplierCommand
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
