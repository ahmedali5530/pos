<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\ProductPriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ProductPriceRepository::class)
 * @Gedmo\Loggable()
 */
class ProductPrice
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Versioned()
     */
    private $product;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned()
     */
    private $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Gedmo\Versioned()
     */
    private $time;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Gedmo\Versioned()
     */
    private $timeTo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned()
     */
    private $day;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned()
     */
    private $week;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned()
     */
    private $month;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned()
     */
    private $quarter;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     */
    private $rate;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     */
    private $minQuantity;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     */
    private $maxQuantity;

    /**
     * @ORM\ManyToOne(targetEntity=ProductVariant::class, inversedBy="prices")
     * @Gedmo\Versioned()
     */
    private $productVariant;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     * @Gedmo\Versioned()
     */
    private $basePrice;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
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

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(?int $date): self
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

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(?int $day): self
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

    public function getTimeTo(): ?\DateTimeInterface
    {
        return $this->timeTo;
    }

    public function setTimeTo(?\DateTimeInterface $timeTo): self
    {
        $this->timeTo = $timeTo;

        return $this;
    }

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(?int $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(?int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getQuarter(): ?int
    {
        return $this->quarter;
    }

    public function setQuarter(?int $quarter): self
    {
        $this->quarter = $quarter;

        return $this;
    }
}
