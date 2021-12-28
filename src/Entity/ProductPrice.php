<?php

namespace App\Entity;

use App\Repository\ProductPriceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductPriceRepository::class)
 */
class ProductPrice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $day;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     */
    private $rate;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     */
    private $minQuantity;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     */
    private $maxQuantity;

    /**
     * @ORM\ManyToOne(targetEntity=ProductVariant::class, inversedBy="prices")
     */
    private $productVariant;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $basePrice;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     */
    private $baseQuantity;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(?string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(?string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getMinQuantity(): ?string
    {
        return $this->minQuantity;
    }

    public function setMinQuantity(?string $minQuantity): self
    {
        $this->minQuantity = $minQuantity;

        return $this;
    }

    public function getMaxQuantity(): ?string
    {
        return $this->maxQuantity;
    }

    public function setMaxQuantity(?string $maxQuantity): self
    {
        $this->maxQuantity = $maxQuantity;

        return $this;
    }

    public function getProductVariant(): ?ProductVariant
    {
        return $this->productVariant;
    }

    public function setProductVariant(?ProductVariant $productVariant): self
    {
        $this->productVariant = $productVariant;

        return $this;
    }

    public function getBasePrice(): ?string
    {
        return $this->basePrice;
    }

    public function setBasePrice(string $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function getBaseQuantity(): ?string
    {
        return $this->baseQuantity;
    }

    public function setBaseQuantity(?string $baseQuantity): self
    {
        $this->baseQuantity = $baseQuantity;

        return $this;
    }
}
