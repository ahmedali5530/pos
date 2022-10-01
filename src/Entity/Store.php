<?php

namespace App\Entity;

use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=StoreRepository::class)
 * @Gedmo\Loggable()
 */
class Store
{
    use ActiveTrait;
    use TimestampableTrait;
    use UuidTrait;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity=Terminal::class, mappedBy="store", cascade={"persist", "remove"})
     */
    private $terminals;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->terminals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Terminal[]
     */
    public function getTerminals(): Collection
    {
        return $this->terminals;
    }

    public function addTerminal(Terminal $terminal): self
    {
        if (!$this->terminals->contains($terminal)) {
            $this->terminals[] = $terminal;
            $terminal->setStore($this);
        }

        return $this;
    }

    public function removeTerminal(Terminal $terminal): self
    {
        if ($this->terminals->removeElement($terminal)) {
            // set the owning side to null (unless already changed)
            if ($terminal->getStore() === $this) {
                $terminal->setStore(null);
            }
        }

        return $this;
    }
}
