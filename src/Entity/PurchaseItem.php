<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PurchaseItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PurchaseItemRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"purchaseItem.read"}},
 *     denormalizationContext={"groups"={"purchaseItem.create", "purchaseItem.update"}}
 * )
 */
class PurchaseItem
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"purchase.read", "purchaseItem.read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create"})
     */
    private $item;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create"})
     */
    private $purchasePrice;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create"})
     */
    private $purchaseUnit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchase.read", "purchaseItem.read", "purchase.create"})
     */
    private $barcode;

    /**
     * @ORM\ManyToOne(targetEntity=Purchase::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $purchase;

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

    public function setPurchaseUnit(string $purchaseUnit): self
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
}
