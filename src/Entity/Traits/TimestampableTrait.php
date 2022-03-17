<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;
use Gedmo\Mapping\Annotation as Gedmo;

trait TimestampableTrait
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }


    public function setDeletedAt($deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }


    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }


    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}