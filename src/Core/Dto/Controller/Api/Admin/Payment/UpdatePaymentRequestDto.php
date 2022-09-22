<?php

namespace App\Core\Dto\Controller\Api\Admin\Payment;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;
use App\Core\Payment\Command\UpdatePaymentCommand\UpdatePaymentCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdatePaymentRequestDto
{
    use StoresRequestDtoTrait;

    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|string
     */
    private $type = null;

    /**
     * @var null|bool
     */
    private $canHaveChangeDue = null;

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

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

        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->type = $data['type'] ?? null;
        $dto->canHaveChangeDue = $data['canHaveChangeDue'] ?? null;
        $dto->stores = $data['stores'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdatePaymentCommand $command)
    {
        $command->setId($this->id);
        $command->setName($this->name);
        $command->setType($this->type);
        $command->setCanHaveChangeDue($this->canHaveChangeDue);
        $command->setStores($this->stores);
    }
}
