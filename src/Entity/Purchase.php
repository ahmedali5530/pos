<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"purchase.read"}},
 *     denormalizationContext={"groups"={"purchase.create", "purchase.update"}}
 * )
 */
class Purchase
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"purchase.read", "supplier.read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Supplier::class, inversedBy="purchases")
     * @Groups({"purchase.read", "purchase.create"})
     */
    private $supplier;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchase.read", "purchase.create"})
     */
    private $store;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseItem::class, mappedBy="purchase", orphanRemoval=true, cascade={"PERSIST", "REMOVE"})
     * @Groups({"purchase.read", "supplier.read", "purchase.create"})
     */
    private $items;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"purchase.read", "purchase.create"})
     */
    private $updateStocks;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"purchase.read", "purchase.create"})
     */
    private $updatePrice;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchase.read", "purchase.create"})
     */
    private $purchasedBy;

    /**
     * @ORM\OneToOne(targetEntity=PurchaseOrder::class, cascade={"persist", "remove"})
     * @Groups({"purchase.read", "purchase.create"})
     */
    private $purchaseOrder;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
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

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    /**
     * @return Collection|PurchaseItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(PurchaseItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setPurchase($this);
        }

        return $this;
    }

    public function removeItem(PurchaseItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getPurchase() === $this) {
                $item->setPurchase(null);
            }
        }

        return $this;
    }

    public function getUpdateStocks(): ?bool
    {
        return $this->updateStocks;
    }

    public function setUpdateStocks(?bool $updateStocks): self
    {
        $this->updateStocks = $updateStocks;

        return $this;
    }

    public function getUpdatePrice(): ?bool
    {
        return $this->updatePrice;
    }

    public function setUpdatePrice(?bool $updatePrice): self
    {
        $this->updatePrice = $updatePrice;

        return $this;
    }

    public function getPurchasedBy(): ?User
    {
        return $this->purchasedBy;
    }

    public function setPurchasedBy(?User $purchasedBy): self
    {
        $this->purchasedBy = $purchasedBy;

        return $this;
    }

    public function getPurchaseOrder(): ?PurchaseOrder
    {
        return $this->purchaseOrder;
    }

    public function setPurchaseOrder(?PurchaseOrder $purchaseOrder): self
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }
}
