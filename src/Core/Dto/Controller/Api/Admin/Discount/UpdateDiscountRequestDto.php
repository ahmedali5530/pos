<?php


namespace App\Core\Dto\Controller\Api\Admin\Discount;


use App\Core\Discont\Command\CreateDiscountCommand\CreateDiscountCommand;
use App\Core\Discount\Command\UpdateDiscountCommand\UpdateDiscountCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateDiscountRequestDto
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $rate;

    /**
     * @var string|null
     */
    private $rateType;

    public static function createFromRequest(
        Request $request
    ): self
    {
        $data = json_decode($request->getContent(), true);
        $dto = new self();

        $dto->name = $data['name'] ?? null;
        $dto->rate = $data['rate'] ?? null;
        $dto->rateType = $data['rateType'] ?? null;

        return $dto;
    }

    public function populateCommand(UpdateDiscountCommand $command)
    {
        $command->setName($this->name);
        $command->setRate($this->rate);
        $command->setRateType($this->rateType);
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getRate(): ?string
    {
        return $this->rate;
    }

    /**
     * @param string|null $rate
     */
    public function setRate(?string $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return string|null
     */
    public function getRateType(): ?string
    {
        return $this->rateType;
    }

    /**
     * @param string|null $rateType
     */
    public function setRateType(?string $rateType): void
    {
        $this->rateType = $rateType;
    }
}