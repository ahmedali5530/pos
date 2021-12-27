<?php


namespace App\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;

trait ActiveTrait
{
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    public function getIsActive()
    {
        return $this->isActive === true;
    }

    public function setIsActive($isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }
}