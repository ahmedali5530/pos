<?php

namespace App\Entity;

use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 * @Gedmo\Loggable()
 */
class Payment
{
    const PAYMENT_TYPE_CASH = 'cash';
    const PAYMENT_TYPE_CREDIT_CARD = 'credit card';
    const PAYMENT_TYPE_POINTS = 'points';
    const PAYMENT_TYPE_CREDIT = 'credit';


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
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned()
     */
    private $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Gedmo\Versioned()
     */
    private $canHaveChangeDue;

    /**
     * @ORM\ManyToMany(targetEntity=Store::class)
     */
    private $stores;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->stores = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCanHaveChangeDue(): ?bool
    {
        return $this->canHaveChangeDue;
    }

    public function setCanHaveChangeDue(?bool $canHaveChangeDue): self
    {
        $this->canHaveChangeDue = $canHaveChangeDue;

        return $this;
    }

    /**
     * @return Collection|Store[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Store $store): self
    {
        if (!$this->stores->contains($store)) {
            $this->stores[] = $store;
        }

        return $this;
    }

    public function removeStore(Store $store): self
    {
        $this->stores->removeElement($store);

        return $this;
    }
}
