<?php

namespace App\Core\Dto\Controller\Api\Admin\Payment;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Payment\Command\CreatePaymentCommand\CreatePaymentCommand;

class CreatePaymentRequestDto
{
    use StoresRequestDtoTrait;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $name = null;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $type = null;

    /**
     * @var null|bool
     */
    private $canHaveChangeDue = null;

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType(?string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setCanHaveChangeDue(?bool $canHaveChangeDue)
    {
        $this->canHaveChangeDue = $canHaveChangeDue;
        return $this;
    }

    public function getCanHaveChangeDue()
    {
        return $this->canHaveChangeDue;
    }

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->name = $data['name'] ?? null;
        $dto->type = $data['type'] ?? null;
        $dto->canHaveChangeDue = $data['canHaveChangeDue'] ?? null;
        $dto->stores = $data['stores'] ?? null;


        return $dto;
    }

    public function populateCommand(CreatePaymentCommand $command)
    {
        $command->setName($this->name);
        $command->setType($this->type);
        $command->setCanHaveChangeDue($this->canHaveChangeDue);
        $command->setStores($this->stores);
    }
}
