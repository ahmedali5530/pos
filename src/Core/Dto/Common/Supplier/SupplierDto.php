<?php

namespace App\Core\Dto\Common\Supplier;

use App\Core\Dto\Common\Common\IdDtoTrait;
use App\Core\Dto\Common\Common\MediaDto;
use App\Core\Dto\Common\Common\NameDtoTrait;
use App\Core\Dto\Common\Common\StoresDtoTrait;
use App\Entity\Supplier;

class SupplierDto
{
    use IdDtoTrait;
    use NameDtoTrait;
    use StoresDtoTrait;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $whatsApp;

    /**
     * @var string|null
     */
    private $fax;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @var MediaDto|null
     */
    private $media;

    /**
     * @var float|null
     */
    private $openingBalance;

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getWhatsApp(): ?string
    {
        return $this->whatsApp;
    }

    /**
     * @param string|null $whatsApp
     */
    public function setWhatsApp(?string $whatsApp): void
    {
        $this->whatsApp = $whatsApp;
    }

    /**
     * @return string|null
     */
    public function getFax(): ?string
    {
        return $this->fax;
    }

    /**
     * @param string|null $fax
     */
    public function setFax(?string $fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return MediaDto|null
     */
    public function getMedia(): ?MediaDto
    {
        return $this->media;
    }

    /**
     * @param MediaDto|null $media
     */
    public function setMedia(?MediaDto $media): void
    {
        $this->media = $media;
    }

    /**
     * @return float|null
     */
    public function getOpeningBalance(): ?float
    {
        return $this->openingBalance;
    }

    /**
     * @param float|null $openingBalance
     */
    public function setOpeningBalance(?float $openingBalance): void
    {
        $this->openingBalance = $openingBalance;
    }


    public static function createFromSupplier (?Supplier $supplier): ?self
    {
        if($supplier === null){
            return null;
        }

        $dto = new self();

        $dto->id = $supplier->getId();
        $dto->name = $supplier->getName();
        $dto->phone = $supplier->getPhone();
        $dto->email = $supplier->getEmail();
        $dto->whatsApp = $supplier->getWhatsApp();
        $dto->fax = $supplier->getFax();
        $dto->address = $supplier->getAddress();
        $dto->media = MediaDto::createFromMedia($supplier->getMedia());
        $dto->openingBalance = $supplier->getOpeningBalance();

        $dto->setStores($supplier->getStores());

        return $dto;
    }
}
