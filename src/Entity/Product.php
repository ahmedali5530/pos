<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @UniqueEntity(fields={"barcode"}, message="Use a different value")
 * @Gedmo\Loggable()
 * @ApiResource(
 *     normalizationContext={"groups"={"product.read", "time.read", "uuid.read"}}
 * )
 * @ApiFilter(filterClass=SearchFilter::class, properties={"name": "partial", "barcode": "exact", "basePrice": "exact", "department.name": "partial", "cost": "exact", "suppliers.name": "partial", "categories.name": "partial", "brands.name": "partial", "taxes.name": "partial"})
 * @ApiFilter(filterClass=OrderFilter::class, properties={"name", "department.name", "barcode", "basePrice", "cost", "suppliers.name", "categories.name", "brands.name", "taxes.name"})
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
     * @Groups({"product.read", "order.read","customer.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read", "supplier.read", "supplierPayment.read", "keyword"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read","customer.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read", "supplier.read", "supplierPayment.read", "keyword"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read","customer.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read", "keyword"})
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read","customer.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read", "keyword"})
     */
    private $barcode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read"})
     */
    private $baseQuantity;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read"})
     */
    private $isAvailable;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read"})
     */
    private $basePrice;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read"})
     */
    private $cost;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read", "keyword"})
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity=ProductVariant::class, mappedBy="product", cascade={"persist", "remove"})
     * @Groups({"product.read"})
     * @ApiSubresource()
     */
    private $variants;

    /**
     * @ORM\OneToMany(targetEntity=ProductPrice::class, mappedBy="product", cascade={"persist", "remove"})
     * @Groups({"product.read"})
     */
    private $prices;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read", "supplier.read", "keyword"})
     */
    private $purchaseUnit;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"product.read", "order.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read", "keyword"})
     */
    private $saleUnit;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class)
     * @Groups({"product.read", "order.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read"})
     */
    private $media;

    /**
     * @ORM\ManyToMany(targetEntity=Brand::class)
     * @Groups({"product.read"})
     */
    private $brands;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class)
     * @Groups({"product.read"})
     */
    private $suppliers;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class)
     * @Groups({"product.read"})
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Store::class)
     * @Groups({"product.read"})
     */
    private $stores;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class)
     * @Groups({"product.read"})
     */
    private $department;

    /**
     * @ORM\ManyToMany(targetEntity=Terminal::class, inversedBy="products")
     * @Groups({"product.read"})
     */
    private $terminals;

    /**
     * @ORM\ManyToMany(targetEntity=Tax::class)
     * @Groups({"product.read"})
     */
    private $taxes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"product.read", "order.read", "terminal.read", "purchaseItem.read", "purchase.read", "purchaseOrder.read"})
     */
    private $manageInventory;

    /**
     * @ORM\OneToMany(targetEntity=ProductInventory::class, mappedBy="product")
     * @Groups({"product.read", "order.read", "terminal.read"})
     */
    private $inventory;

    public function __construct()
    {
        $this->variants = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
        $this->stores = new ArrayCollection();
        $this->terminals = new ArrayCollection();
        $this->taxes = new ArrayCollection();
        $this->inventory = new ArrayCollection();
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

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Store[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Store $store): self
    {
        if (!$this->stores->contains($store)) {
            $this->stores[] = $store;
        }

        return $this;
    }

    public function removeStore(Store $store): self
    {
        $this->stores->removeElement($store);

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection|Terminal[]
     */
    public function getTerminals(): Collection
    {
        return $this->terminals;
    }

    public function addTerminal(Terminal $terminal): self
    {
        if (!$this->terminals->contains($terminal)) {
            $this->terminals[] = $terminal;
        }

        return $this;
    }

    public function removeTerminal(Terminal $terminal): self
    {
        $this->terminals->removeElement($terminal);

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

    public function getManageInventory(): ?bool
    {
        return $this->manageInventory;
    }

    public function setManageInventory(?bool $manageInventory): self
    {
        $this->manageInventory = $manageInventory;

        return $this;
    }

    /**
     * @return Collection|ProductInventory[]
     */
    public function getInventory(): Collection
    {
        return $this->inventory;
    }

    public function addInventory(ProductInventory $inventory): self
    {
        if (!$this->inventory->contains($inventory)) {
            $this->inventory[] = $inventory;
            $inventory->setProduct($this);
        }

        return $this;
    }

    public function removeInventory(ProductInventory $inventory): self
    {
        if ($this->inventory->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getProduct() === $this) {
                $inventory->setProduct(null);
            }
        }

        return $this;
    }
}
