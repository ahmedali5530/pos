<?php


namespace App\Core\Dto\Common\Store;


use App\Core\Dto\Common\Terminal\TerminalShortDto;
use App\Entity\Store;

class StoreShortDto extends StoreDto
{
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
        $dto->setId($store->getId());
        $dto->setName($store->getName());
        $dto->setLocation($store->getLocation());

        return $dto;
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
