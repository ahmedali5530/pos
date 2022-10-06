<?php


namespace App\Core\Dto\Common\Store;


use App\Core\Dto\Common\Terminal\TerminalShortDto;
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
     * @var string|null
     */
    private $location;

    /**
     * @var TerminalShortDto[]
     */
    private $terminals = [];

    public static function createFromStore(?Store $store): ?self
    {
        if($store === null){
            return null;
        }
        $dto = new self();
        $dto->id = $store->getId();
        $dto->name = $store->getName();
        $dto->location = $store->getLocation();
        foreach($store->getTerminals() as $terminal){
            $dto->terminals[] = TerminalShortDto::createFromTerminal($terminal);
        }

        return $dto;
    }

    public static function createFromArray(array $data): self
    {
        $dto = new self();

        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->location = $data['location'] ?? null;

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
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return TerminalShortDto[]
     */
    public function getTerminals(): array
    {
        return $this->terminals;
    }

    /**
     * @param TerminalShortDto[] $terminals
     */
    public function setTerminals(array $terminals): void
    {
        $this->terminals = $terminals;
    }
}
