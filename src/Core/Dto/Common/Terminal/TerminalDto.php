<?php

namespace App\Core\Dto\Common\Terminal;

use App\Core\Dto\Common\Common\ActiveDtoTrait;
use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\DescriptionDtoTrait;
use App\Core\Dto\Common\Common\IdDtoTrait;
use App\Core\Dto\Common\Common\KeywordDto;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
use App\Core\Dto\Common\Product\ProductShortDto;
use App\Core\Dto\Common\Store\StoreShortDto;
use App\Entity\Terminal;

class TerminalDto
{
    use IdDtoTrait, DescriptionDtoTrait, ActiveDtoTrait, UuidDtoTrait,
        TimestampsDtoTrait;

    /**
     * @var string
     */
    private $code;

    /**
     * @var StoreShortDto|null
     */
    private $store;

    /**
     * @var ProductShortDto[]
     */
    private $products = [];


    public static function createFromTerminal(?Terminal $terminal): ?self
    {
        if($terminal === null){
            return null;
        }

        $dto = new self();

        $dto->id = $terminal->getId();
        $dto->code = $terminal->getCode();
        $dto->description = $terminal->getDescription();
        $dto->isActive = $terminal->getIsActive();
        $dto->uuid = $terminal->getUuid();
        $dto->createdAt = DateTimeDto::createFromDateTime($terminal->getCreatedAt());
        $dto->updatedAt = DateTimeDto::createFromDateTime($terminal->getUpdatedAt());
        $dto->store = StoreShortDto::createFromStore($terminal->getStore());
        foreach($terminal->getProducts() as $product){
            $dto->products[] = new KeywordDto($product->getName(), $product->getId());
        }

        return $dto;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return StoreShortDto|null
     */
    public function getStore(): ?StoreShortDto
    {
        return $this->store;
    }

    /**
     * @param StoreShortDto|null $store
     */
    public function setStore(?StoreShortDto $store): void
    {
        $this->store = $store;
    }

    /**
     * @return ProductShortDto[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param ProductShortDto[] $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }


}
