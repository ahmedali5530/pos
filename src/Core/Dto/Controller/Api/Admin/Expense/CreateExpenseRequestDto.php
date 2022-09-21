<?php

namespace App\Core\Dto\Controller\Api\Admin\Expense;

use App\Core\Dto\Common\Common\StoreDtoTrait;
use Carbon\Carbon;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Expense\Command\CreateExpenseCommand\CreateExpenseCommand;

class CreateExpenseRequestDto
{
    use StoreDtoTrait;

    /**
     * @var null|float
     * @Assert\NotBlank(normalizer="trim")
     */
    private $amount = null;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $description = null;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $dateTime;

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

    /**
     * @return string|null
     */
    public function getDateTime(): ?string
    {
        return $this->dateTime;
    }

    /**
     * @param string|null $dateTime
     */
    public function setDateTime(?string $dateTime): void
    {
        $this->dateTime = $dateTime;
    }


    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->amount = $data['amount'] ?? null;
        $dto->description = $data['description'] ?? null;
        $dto->dateTime = $data['dateTime'] ?? null;
        $dto->store = $data['store'] ?? null;


        return $dto;
    }

    public function populateCommand(CreateExpenseCommand $command)
    {
        $command->setAmount($this->amount);
        $command->setDescription($this->description);

        if($this->dateTime !== null) {
            $command->setCreatedAt(Carbon::parse($this->dateTime)->toDateTimeImmutable());
        }else{
            $command->setCreatedAt(Carbon::now()->toDateTimeImmutable());
        }
        $command->setStore($this->store);
    }
}
