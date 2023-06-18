<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 * @UniqueEntity(fields={"purchaseNumber"})
 * @ApiResource(
 *     normalizationContext={"groups"={"purchase.read", "time.read", "uuid.read"}, "skip_null_values"=false},
 *     denormalizationContext={"groups"={"purchase.create"}}
 * )
 * @ApiFilter(filterClass=SearchFilter::class, properties={"purchaseNumber": "exact", "purchaseOrder.poNumber": "exact", "supplier.name": "ipartial", "paymentType.name": "ipartial", "createdAt": "partial"})
 * @ApiFilter(filterClass=OrderFilter::class, properties={"purchaseNumber", "purchaseOrder.poNumber", "supplier.name", "paymentType.name", "createdAt"})
 */
class Purchase
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"purchase.read", "supplier.read", "supplier.read", "supplierPayment.read"})
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
     * @Groups({"purchase.read", "supplier.read", "purchase.create", "supplierPayment.read"})
     */
    private $items;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"purchase.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $updateStocks;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"purchase.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $updatePrice;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchase.read", "purchase.create", "supplier.read"})
     */
    private $purchasedBy;

    /**
     * @ORM\OneToOne(targetEntity=PurchaseOrder::class, cascade={"persist", "remove"})
     * @Groups({"purchase.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $purchaseOrder;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"purchase.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $purchaseNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"purchase.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $purchaseMode;

    /**
     * @ORM\ManyToOne(targetEntity=Payment::class)
     * @Groups({"purchase.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $paymentType;

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

    public function getPurchaseNumber(): ?string
    {
        return $this->purchaseNumber;
    }

    public function setPurchaseNumber(?string $purchaseNumber): self
    {
        $this->purchaseNumber = $purchaseNumber;

        return $this;
    }

    public function getPurchaseMode(): ?string
    {
        return $this->purchaseMode;
    }

    public function setPurchaseMode(?string $purchaseMode): self
    {
        $this->purchaseMode = $purchaseMode;

        return $this;
    }

    public function getPaymentType(): ?Payment
    {
        return $this->paymentType;
    }

    public function setPaymentType(?Payment $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return float
     * @Groups({"purchase.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     * @ApiProperty()
     */
    public function getTotal(): float
    {
        $total = 0;
        foreach($this->getItems() as $item){
            $total += $item->getQuantity() * $item->getPurchasePrice();
        }

        return $total;
    }
}
