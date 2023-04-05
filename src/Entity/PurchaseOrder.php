<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PurchaseOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PurchaseOrderRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"purchaseOrder.read"}},
 *     denormalizationContext={"groups"={"purchaseOrder.create", "purchaseOrder.update"}}
 * )
 */
class PurchaseOrder
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"purchaseOrder.read", "purchase.read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"purchaseOrder.read", "purchase.read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Supplier::class, inversedBy="purchaseOrders")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchaseOrder.read", "purchase.read"})
     */
    private $supplier;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseOrderItem::class, mappedBy="purchaseOrder", orphanRemoval=true)
     * @Groups({"purchaseOrder.read", "purchase.read"})
     */
    private $items;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchaseOrder.read"})
     */
    private $store;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchaseOrder.read"})
     */
    private $poNumber;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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
}
