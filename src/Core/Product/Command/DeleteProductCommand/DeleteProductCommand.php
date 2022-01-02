<?php

namespace App\Core\Product\Command\DeleteProductCommand;

class DeleteProductCommand
{
    private $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($field)
    {
        $this->id = $field;
        return $this;
    }
}