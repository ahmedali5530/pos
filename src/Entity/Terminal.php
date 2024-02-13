<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\TerminalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=TerminalRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"terminal.read", "time.read", "uuid.read", "active.read"}},
 *     denormalizationContext={"groups"={"terminal.create", "active.read"}}
 * )
 * @ApiFilter(filterClass=SearchFilter::class, properties={"code": "exact", "description": "ipartial", "products.name": "ipartial", "store.id": "exact"})
 * @ApiFilter(filterClass=OrderFilter::class, properties={"code", "description", "products.name"})
 * @ApiFilter(filterClass=BooleanFilter::class, properties={"isActive"})
 */
class Terminal
{
    use ActiveTrait;
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"store.read", "product.read", "terminal.read", "order.read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"store.read", "product.read", "terminal.read", "order.read", "terminal.create"})
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"store.read", "product.read", "terminal.read", "order.read", "terminal.create"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="terminals")
     * @Groups({"terminal.read", "terminal.create"})
     */
    private $store;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="terminals")
     * @Groups({"terminal.read", "terminal.create"})
     */
    private $products;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addTerminal($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeTerminal($this);
        }

        return $this;
    }
}
