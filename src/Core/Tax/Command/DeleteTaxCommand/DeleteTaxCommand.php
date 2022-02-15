<?php 

namespace App\Core\Tax\Command\DeleteTaxCommand;

class DeleteTaxCommand
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
