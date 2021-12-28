<?php


namespace App\Core\Dto\Common\Store;


use App\Core\Dto\Common\Location\LocationDto;
use App\Entity\Store;

class StoreDto
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var LocationDto|null
     */
    private $location;

    public static function createFromStore(?Store $store): ?self
    {
        if($store === null){
            return null;
        }
        $dto = new self();
        $dto->id = $store->getId();
        $dto->name = $store->getName();
        $dto->location = LocationDto::createFromLocation($store->getLocation());

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
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
     * @return LocationDto|null
     */
    public function getLocation(): ?LocationDto
    {
        return $this->location;
    }

    /**
     * @param LocationDto|null $location
     */
    public function setLocation(?LocationDto $location): void
    {
        $this->location = $location;
    }
}