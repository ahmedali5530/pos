<?php

namespace App\Core\Dto\Controller\Api\Admin\Supplier;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Supplier\Command\CreateSupplierCommand\CreateSupplierCommand;

class CreateSupplierRequestDto
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
    private $phone = null;

    /**
     * @var null|string
     */
    private $email = null;

    /**
     * @var null|string
     */
    private $whatsApp = null;

    /**
     * @var null|string
     */
    private $fax = null;

    /**
     * @var null|string
     */
    private $address = null;

    /**
     * @var string|null
     */
    private $openingBalance;

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPhone(?string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setEmail(?string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setWhatsApp(?string $whatsApp)
    {
        $this->whatsApp = $whatsApp;
        return $this;
    }

    public function getWhatsApp()
    {
        return $this->whatsApp;
    }

    public function setFax(?string $fax)
    {
        $this->fax = $fax;
        return $this;
    }

    public function getFax()
    {
        return $this->fax;
    }

    public function setAddress(?string $address)
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getOpeningBalance(): ?string
    {
        return $this->openingBalance;
    }

    /**
     * @param string|null $openingBalance
     */
    public function setOpeningBalance(?string $openingBalance): void
    {
        $this->openingBalance = $openingBalance;
    }


    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->name = $data['name'] ?? null;
        $dto->phone = $data['phone'] ?? null;
        $dto->email = $data['email'] ?? null;
        $dto->whatsApp = $data['whatsApp'] ?? null;
        $dto->fax = $data['fax'] ?? null;
        $dto->address = $data['address'] ?? null;
        $dto->stores = $data['stores'] ?? null;
        $dto->openingBalance = $data['openingBalance'] ?? null;


        return $dto;
    }

    public function populateCommand(CreateSupplierCommand $command)
    {
        $command->setName($this->name);
        $command->setPhone($this->phone);
        $command->setEmail($this->email);
        $command->setWhatsApp($this->whatsApp);
        $command->setFax($this->fax);
        $command->setAddress($this->address);
        $command->setStores($this->stores);
        $command->setOpeningBalance($this->openingBalance);
    }
}
