<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PurchaseItemVariantRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PurchaseItemVariantRepository::class)
 * @ApiResource()
 */
class PurchaseItemVariant
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
     * @ORM\ManyToOne(targetEntity=ProductVariant::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $variant;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $purchasePrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $purchaseUnit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $barcode;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=PurchaseItem::class, inversedBy="variants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $purchaseItem;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create", "supplier.read", "supplierPayment.read"})
     */
    private $quantityRequested;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVariant(): ?ProductVariant
    {
        return $this->variant;
    }

    public function setVariant(?ProductVariant $variant): self
    {
        $this->variant = $variant;

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

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getPurchaseItem(): ?PurchaseItem
    {
        return $this->purchaseItem;
    }

    public function setPurchaseItem(?PurchaseItem $purchaseItem): self
    {
        $this->purchaseItem = $purchaseItem;

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
}
