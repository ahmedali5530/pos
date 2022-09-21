<?php


namespace App\Core\Dto\Controller\Api\Admin\Discount;


use App\Core\Discont\Command\CreateDiscountCommand\CreateDiscountCommand;
use App\Core\Dto\Common\Common\StoresRequestDtoTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateDiscountRequestDto
{
    use StoresRequestDtoTrait;

    /**
     * @var string|null
     * @Assert\NotBlank()
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
        $dto->stores = $data['stores'] ?? null;

        return $dto;
    }

    public function populateCommand(CreateDiscountCommand $command)
    {
        $command->setName($this->name);
        $command->setRate($this->rate);
        $command->setRateType($this->rateType);
        $command->setStores($this->stores);
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
