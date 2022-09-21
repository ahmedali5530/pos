<?php


namespace App\Core\Dto\Common\Payment;


use App\Core\Dto\Common\Common\StoresDtoTrait;
use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Entity\Payment;

class PaymentDto
{
    use StoresDtoTrait;

    /**
     * @var int
     * @ConstraintValidEntity(entityName="Order payment", class="App\Entity\Payment")
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool|null
     */
    private $canHaveChangeDue;

    public static function createFromPayment(?Payment $payment): ?self
    {
        if($payment === null){
            return null;
        }

        $dto = new self();
        $dto->id = $payment->getId();
        $dto->name = $payment->getName();
        $dto->type = $payment->getType();
        $dto->canHaveChangeDue = $payment->getCanHaveChangeDue();
        $dto->setStores($payment->getStores());

        return $dto;
    }

    public static function createFromArray(?array $data): ?self
    {
        if($data === null){
            return null;
        }

        $dto = new self();
        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->type = $data['type'] ?? null;
        $dto->canHaveChangeDue = $data['canHaveChangeDue'] ?? null;

        return $dto;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool|null
     */
    public function getCanHaveChangeDue(): ?bool
    {
        return $this->canHaveChangeDue;
    }

    /**
     * @param bool|null $canHaveChangeDue
     */
    public function setCanHaveChangeDue(?bool $canHaveChangeDue): void
    {
        $this->canHaveChangeDue = $canHaveChangeDue;
    }
}
