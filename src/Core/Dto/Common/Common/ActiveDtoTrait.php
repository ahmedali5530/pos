<?php


namespace App\Core\Dto\Common\Common;


trait ActiveDtoTrait
{
    /**
     * @var bool|null;
     */
    private $isActive;

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool|null $isActive
     */
    public function setIsActive(?bool $isActive): void
    {
        $this->isActive = $isActive;
    }
}