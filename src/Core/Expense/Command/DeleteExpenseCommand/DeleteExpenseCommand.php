<?php 

namespace App\Core\Expense\Command\DeleteExpenseCommand;

class DeleteExpenseCommand
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
