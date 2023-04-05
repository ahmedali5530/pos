<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderProductRepository::class)
 * @Gedmo\Loggable()
 * @ApiResource()
 */
class OrderProduct
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order.read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"order.read"})
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=ProductVariant::class)
     * @Groups({"order.read"})
     */
    private $variant;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     * @Groups({"order.read"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     * @Groups({"order.read"})
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"order.read"})
     */
    private $isSuspended;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"order.read"})
     */
    private $isDeleted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"order.read"})
     */
    private $isReturned;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="items")
     * @ORM\JoinColumn(name="orderId", referencedColumnName="id")
     */
    private $order;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Groups({"order.read"})
     */
    private $discount;

    /**
     * @ORM\ManyToMany(targetEntity=Tax::class)
     * @Groups({"order.read"})
     */
    private $taxes;

    public function __construct()
    {
        $this->taxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsSuspended(): ?bool
    {
        return $this->isSuspended;
    }

    public function setIsSuspended(?bool $isSuspended): self
    {
        $this->isSuspended = $isSuspended;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getIsReturned(): ?bool
    {
        return $this->isReturned;
    }

    public function setIsReturned(?bool $isReturned): self
    {
        $this->isReturned = $isReturned;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return Collection|Tax[]
     */
    public function getTaxes(): Collection
    {
        return $this->taxes;
    }

    public function addTax(Tax $tax): self
    {
        if (!$this->taxes->contains($tax)) {
            $this->taxes[] = $tax;
        }

        return $this;
    }

    public function removeTax(Tax $tax): self
    {
        $this->taxes->removeElement($tax);

        return $this;
    }
}
