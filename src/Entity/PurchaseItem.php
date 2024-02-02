<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PurchaseItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ORM\Entity(repositoryClass=PurchaseItemRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"purchaseItem.read", "time.read", "uuid.read"}}
 * )
 * @ApiFilter(filterClass=SearchFilter::class, properties={"item.id": "exact", "quantity": "exact", "quantityRequested": "exact", "purchasePrice": "exact", "createdAt": "partial", "purchase.purchaseNumber": "exact"})
 * @ApiFilter(filterClass=OrderFilter::class, properties={"purchase.purchaseNumber", "createdAt", "quantity", "purchasePrice", "quantityRequested"})
 */
class PurchaseItem
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"purchase.read", "purchaseItem.read", "supplier.read", "supplierPayment.read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchase.read", "purchaseItem.read", "supplier.read", "purchase.create", "supplierPayment.read"})
     */
    private $item;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchase.read", "purchaseItem.read", "supplier.read", "purchase.create", "supplierPayment.read"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchase.read", "purchaseItem.read", "supplier.read", "purchase.create", "supplierPayment.read"})
     */
    private $purchasePrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "supplier.read", "purchase.create", "supplierPayment.read"})
     */
    private $purchaseUnit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "supplier.read", "purchase.create", "supplierPayment.read"})
     */
    private $barcode;

    /**
     * @ORM\ManyToOne(targetEntity=Purchase::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchaseItem.read"})
     */
    private $purchase;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "supplier.read", "purchase.create", "supplierPayment.read"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseItemVariant::class, mappedBy="purchaseItem", orphanRemoval=true, cascade={"PERSIST"})
     * @Groups({"purchase.read", "purchaseItem.read", "supplier.read", "purchase.create", "supplierPayment.read"})
     */
    private $variants;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "supplier.read", "purchase.create", "supplierPayment.read"})
     */
    private $quantityRequested;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create"})
     */
    private $isExpire;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create"})
     */
    private $expiryDate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create"})
     */
    private $quantityUsed;

    public function __construct()
    {
        $this->variants = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?Product
    {
        return $this->item;
    }

    public function setItem(?Product $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPurchasePrice(): ?string
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(string $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getPurchaseUnit(): ?string
    {
        return $this->purchaseUnit;
    }

    public function setPurchaseUnit(?string $purchaseUnit): self
    {
        $this->purchaseUnit = $purchaseUnit;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return Collection|PurchaseItemVariant[]
     */
    public function getVariants(): Collection
    {
        return $this->variants;
    }

    public function addVariant(PurchaseItemVariant $variant): self
    {
        if (!$this->variants->contains($variant)) {
            $this->variants[] = $variant;
            $variant->setPurchaseItem($this);
        }

        return $this;
    }

    public function removeVariant(PurchaseItemVariant $variant): self
    {
        if ($this->variants->removeElement($variant)) {
            // set the owning side to null (unless already changed)
            if ($variant->getPurchaseItem() === $this) {
                $variant->setPurchaseItem(null);
            }
        }

        return $this;
    }

    public function getQuantityRequested(): ?string
    {
        return $this->quantityRequested;
    }

    public function setQuantityRequested(?string $quantityRequested): self
    {
        $this->quantityRequested = $quantityRequested;

        return $this;
    }

    public function getIsExpire(): ?bool
    {
        return $this->isExpire;
    }

    public function setIsExpire(?bool $isExpire): self
    {
        $this->isExpire = $isExpire;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(?\DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getQuantityUsed(): ?string
    {
        return $this->quantityUsed;
    }

    public function setQuantityUsed(?string $quantityUsed): self
    {
        $this->quantityUsed = $quantityUsed;

        return $this;
    }
}
