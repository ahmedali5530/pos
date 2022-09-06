<?php 

namespace App\Core\Dto\Controller\Api\Admin\Expense;

use App\Core\Expense\Command\UpdateExpenseCommand\UpdateExpenseCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateExpenseRequestDto
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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        $dto->amount = $data['amount'] ?? null;
        $dto->description = $data['description'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateExpenseCommand $command)
    {
        $command->setId($this->id);
        $command->setAmount($this->amount);
        $command->setDescription($this->description);
    }
}
