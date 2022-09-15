<?php 

namespace App\Core\Store\Command\DeleteStoreCommand;

class DeleteStoreCommand
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
