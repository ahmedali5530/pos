<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PurchaseOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;


/**
 * @ORM\Entity(repositoryClass=PurchaseOrderRepository::class)
 * @UniqueEntity(fields={"poNumber"})
 * @ApiResource(
 *     normalizationContext={"groups"={"purchaseOrder.read", "time.read", "uuid.read"}, "skip_null_values"=false},
 *     denormalizationContext={"groups"={"purchaseOrder.create"}}
 * )
 * @ApiFilter(filterClass=BooleanFilter::class, properties={"isUsed"})
 * @ApiFilter(filterClass=SearchFilter::class, properties={"poNumber": "exact", "supplier.name": "ipartial", "createdAt": "partial"})
 * @ApiFilter(filterClass=OrderFilter::class, properties={"poNumber", "supplier.name", "createdAt"})
 */
class PurchaseOrder
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"purchaseOrder.read", "purchase.read", "purchaseOrder.create", "supplierPayment.read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Supplier::class, inversedBy="purchaseOrders")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $supplier;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseOrderItem::class, mappedBy="purchaseOrder", orphanRemoval=true, orphanRemoval=true, cascade={"PERSIST", "REMOVE"})
     * @Groups({"purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $items;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchaseOrder.read", "purchaseOrder.create"})
     */
    private $store;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchaseOrder.read", "purchaseOrder.create", "purchase.read", "supplierPayment.read"})
     */
    private $poNumber;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"purchaseOrder.read", "purchaseOrder.create", "purchase.read", "supplierPayment.read"})
     */
    private $isUsed;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * @return Collection|PurchaseOrderItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(PurchaseOrderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setPurchaseOrder($this);
        }

        return $this;
    }

    public function removeItem(PurchaseOrderItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getPurchaseOrder() === $this) {
                $item->setPurchaseOrder(null);
            }
        }

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getPoNumber(): ?string
    {
        return $this->poNumber;
    }

    public function setPoNumber(?string $poNumber): self
    {
        $this->poNumber = $poNumber;

        return $this;
    }

    public function getIsUsed(): ?bool
    {
        return $this->isUsed;
    }

    public function setIsUsed(?bool $isUsed): self
    {
        $this->isUsed = $isUsed;

        return $this;
    }
}
