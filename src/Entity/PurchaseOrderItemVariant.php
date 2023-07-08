<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PurchaseOrderItemVariantRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PurchaseOrderItemVariantRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"purchaseOrderItemVariant.read", "time.read", "uuid.read"}}
 * )
 */
class PurchaseOrderItemVariant
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create", "purchaseOrder.create"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProductVariant::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $variant;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $purchasePrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $purchaseUnit;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=PurchaseOrderItem::class, inversedBy="variants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $purchaseOrderItem;

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

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getPurchaseOrderItem(): ?PurchaseOrderItem
    {
        return $this->purchaseOrderItem;
    }

    public function setPurchaseOrderItem(?PurchaseOrderItem $purchaseOrderItem): self
    {
        $this->purchaseOrderItem = $purchaseOrderItem;

        return $this;
    }
}
