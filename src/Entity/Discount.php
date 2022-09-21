<?php

namespace App\Entity;

use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\DiscountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=DiscountRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable()
 */
class Discount
{
    use ActiveTrait;
    use TimestampableTrait;
    use UuidTrait;

    const SCOPE_OPEN = 'open';
    const SCOPE_EXACT = 'exact';

    const RATE_FIXED = 'fixed';
    const RATE_PERCENT = 'percent';

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
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     */
    private $rate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $rateType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $scope;

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

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(?string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getRateType(): ?string
    {
        return $this->rateType;
    }

    public function setRateType(?string $rateType): self
    {
        $this->rateType = $rateType;

        return $this;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setScope(?string $scope): self
    {
        $this->scope = $scope;

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
