<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\ProductVariantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ProductVariantRepository::class)
 * @Gedmo\Loggable()
 * @ApiResource(
 *     normalizationContext={"groups"={"variant.read", "time.read", "uuid.read"}}
 * )
 */
class ProductVariant
{
    use TimestampableTrait, UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product.read", "purchase.read", "supplier.read", "variant.read", "purchaseOrder.read", "product.write", "keyword", "barcode.read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="variants")
     * @Gedmo\Versioned()
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "purchase.read", "supplier.read", "variant.read", "purchaseOrder.read", "product.write", "barcode.read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"product.read", "purchase.read", "supplier.read", "variant.read", "purchaseOrder.read", "product.write", "barcode.read"})
     */
    private $attributeName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "purchase.read", "supplier.read", "variant.read", "purchaseOrder.read", "product.write", "barcode.read"})
     */
    private $attributeValue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "purchase.read", "supplier.read", "variant.read", "product.write", "keyword", "barcode.read"})
     */
    private $barcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"product.read", "product.write"})
     */
    private $sku;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "product.write", "keyword", "barcode.read"})
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=ProductPrice::class, mappedBy="productVariant")
     * @Groups({"product.read", "product.write"})
     */
    private $prices;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, options={"default": 0})
     * @Groups({"product.read", "product.write", "keyword", "barcode.read"})
     */
    private $quantity;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = trim($price) === '' ? null : $price;

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
            $price->setProductVariant($this);
        }

        return $this;
    }

    public function removePrice(ProductPrice $price): self
    {
        if ($this->prices->removeElement($price)) {
            // set the owning side to null (unless already changed)
            if ($price->getProductVariant() === $this) {
                $price->setProductVariant(null);
            }
        }

        return $this;
    }

    public function getAttributeName(): ?string
    {
        return $this->attributeName;
    }

    public function setAttributeName(?string $attributeName): self
    {
        $this->attributeName = $attributeName;

        return $this;
    }

    public function getAttributeValue(): ?string
    {
        return $this->attributeValue;
    }

    public function setAttributeValue(?string $attributeValue): self
    {
        $this->attributeValue = $attributeValue;

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
}
