<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\PurchaseOrderItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PurchaseOrderItemRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"purchaseOrderItem.read", "time.read", "uuid.read"}}
 * )
 */
class PurchaseOrderItem
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $item;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $unit;

    /**
     * @ORM\ManyToOne(targetEntity=PurchaseOrder::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchaseOrderItem.read"})
     */
    private $purchaseOrder;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseOrderItemVariant::class, mappedBy="purchaseOrderItem", orphanRemoval=true, cascade={"persist"})
     * @Groups({"purchaseOrderItem.read", "purchaseOrder.read", "purchase.read", "purchaseOrder.create"})
     */
    private $variants;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

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
     * @return Collection|PurchaseOrderItemVariant[]
     */
    public function getVariants(): Collection
    {
        return $this->variants;
    }

    public function addVariant(PurchaseOrderItemVariant $variant): self
    {
        if (!$this->variants->contains($variant)) {
            $this->variants[] = $variant;
            $variant->setPurchaseOrderItem($this);
        }

        return $this;
    }

    public function removeVariant(PurchaseOrderItemVariant $variant): self
    {
        if ($this->variants->removeElement($variant)) {
            // set the owning side to null (unless already changed)
            if ($variant->getPurchaseOrderItem() === $this) {
                $variant->setPurchaseOrderItem(null);
            }
        }

        return $this;
    }
}
