<?php


namespace App\Core\Dto\Common\Common;


trait UuidDtoTrait
{
    /**
     * @var string|null
     */
    private $uuid;

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string|null $uuid
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }
}