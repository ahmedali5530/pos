<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 * @Gedmo\Loggable()
 * @ApiResource(
 *     normalizationContext={"groups"={"payment.read", "time.read", "uuid.read", "active.read"}}
 * )
 * @ApiFilter(filterClass=SearchFilter::class, properties={"name": "partial", "type": "exact"})
 * @ApiFilter(filterClass=BooleanFilter::class, properties={"isActive"})
 * @ApiFilter(filterClass=OrderFilter::class, properties={"name", "type"})
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
     * @Groups({"payment.read", "order.read","customer.read", "purchase.read", "supplier.read", "supplierPayment.read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned()
     * @Groups({"payment.read", "order.read","customer.read", "purchase.read", "supplier.read", "supplierPayment.read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned()
     * @Groups({"payment.read", "order.read","customer.read", "purchase.read", "supplier.read", "supplierPayment.read"})
     */
    private $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"payment.read"})
     */
    private $canHaveChangeDue;

    /**
     * @ORM\ManyToMany(targetEntity=Store::class)
     * @Groups({"payment.read"})
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
