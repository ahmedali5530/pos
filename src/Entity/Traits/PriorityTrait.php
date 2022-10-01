<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PriorityTrait
{
    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $priority;

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority): void
    {
        $this->priority = $priority;
    }
}
