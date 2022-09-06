<?php 

namespace App\Core\Expense\Command\UpdateExpenseCommand;

class UpdateExpenseCommand
{
    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|float
     */
    private $amount = null;

    /**
     * @var null|string
     */
    private $description = null;

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAmount(?float $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
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
