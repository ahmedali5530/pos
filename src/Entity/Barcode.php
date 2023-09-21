<?php

namespace App\Entity;

use App\Repository\BarcodeRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=BarcodeRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"barcode.read", "time.read", "uuid.read", "product.read"}}
 * )
 * @ApiFilter(filterClass=SearchFilter::class, properties={"barcode": "exact"})
 * @ApiFilter(filterClass=OrderFilter::class, properties={"name"})
 */
class Barcode
{
    use ActiveTrait;
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"barcode.read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"barcode.read"})
     */
    private $barcode;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @Groups({"barcode.read"})
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity=ProductVariant::class)
     * @Groups({"barcode.read"})
     */
    private $variant;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"barcode.read"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"barcode.read"})
     */
    private $measurement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"barcode.read"})
     */
    private $unit;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"barcode.read"})
     */
    private $usages;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"barcode.read"})
     */
    private $used;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
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

    public function getVariant(): ?ProductVariant
    {
        return $this->variant;
    }

    public function setVariant(?ProductVariant $variant): self
    {
        $this->variant = $variant;

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

    public function getMeasurement(): ?string
    {
        return $this->measurement;
    }

    public function setMeasurement(?string $measurement): self
    {
        $this->measurement = $measurement;

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

    public function getUsages(): ?int
    {
        return $this->usages;
    }

    public function setUsages(?int $usages): self
    {
        $this->usages = $usages;

        return $this;
    }

    public function getUsed(): ?int
    {
        return $this->used;
    }

    public function setUsed(?int $used): self
    {
        $this->used = $used;

        return $this;
    }
}
