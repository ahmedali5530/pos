<?php


namespace App\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;

trait ActiveTrait
{
    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default": true})
     */
    private $isActive = true;

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
