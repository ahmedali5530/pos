<?php


namespace App\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

trait UuidTrait
{
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"uuid.read"})
     */
    private $uuid;

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
