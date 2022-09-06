<?php


namespace App\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $uuid;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }
}
