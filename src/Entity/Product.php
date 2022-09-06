<?php

namespace App\Entity;

use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @UniqueEntity(fields={"barcode"}, message="Use a different value")
 * @Gedmo\Loggable()
 */
class Product
{
    use ActiveTrait;
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     */
    private $barcode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned()
     */
    private $baseQuantity;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Gedmo\Versioned()
     */
    private $isAvailable;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     */
    private $basePrice;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @Gedmo\Versioned()
     */
    private $category;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity=ProductVariant::class, mappedBy="product")
     */
    private $variants;

    /**
     * @ORM\OneToMany(targetEntity=ProductPrice::class, mappedBy="product")
     */
    private $prices;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Gedmo\Versioned()
     */
    private $purchaseUnit;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Gedmo\Versioned()
     */
    private $saleUnit;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class)
     */
    private $media;

    /**
     * @ORM\ManyToMany(targetEntity=Brand::class)
     */
    private $brands;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class)
     */
    private $suppliers;

    public function __construct()
    {
        $this->variants = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): self
    {
        $this->sku = $sku;

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

    public function getBaseQuantity(): ?int
    {
        return $this->baseQuantity;
    }

    public function setBaseQuantity(?int $baseQuantity): self
    {
        $this->baseQuantity = $baseQuantity;

        return $this;
    }

    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(?bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getBasePrice(): ?string
    {
        return $this->basePrice;
    }

    public function setBasePrice(?string $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(?string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection|ProductVariant[]
     */
    public function getVariants(): Collection
    {
        return $this->variants;
    }

    public function addVariant(ProductVariant $variant): self
    {
        if (!$this->variants->contains($variant)) {
            $this->variants[] = $variant;
            $variant->setProduct($this);
        }

        return $this;
    }

    public function removeVariant(ProductVariant $variant): self
    {
        if ($this->variants->removeElement($variant)) {
            // set the owning side to null (unless already changed)
            if ($variant->getProduct() === $this) {
                $variant->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductPrice[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(ProductPrice $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setProduct($this);
        }

        return $this;
    }

    public function removePrice(ProductPrice $price): self
    {
        if ($this->prices->removeElement($price)) {
            // set the owning side to null (unless already changed)
            if ($price->getProduct() === $this) {
                $price->setProduct(null);
            }
        }

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(?string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return Collection|Brand[]
     */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function addBrand(Brand $brand): self
    {
        if (!$this->brands->contains($brand)) {
            $this->brands[] = $brand;
        }

        return $this;
    }

    public function removeBrand(Brand $brand): self
    {
        $this->brands->removeElement($brand);

        return $this;
    }

    /**
     * @return Collection|Supplier[]
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Supplier $supplier): self
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers[] = $supplier;
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): self
    {
        $this->suppliers->removeElement($supplier);

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

    public function getSaleUnit(): ?string
    {
        return $this->saleUnit;
    }

    public function setSaleUnit(?string $saleUnit): self
    {
        $this->saleUnit = $saleUnit;

        return $this;
    }
}
