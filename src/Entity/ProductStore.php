<?php

namespace App\Entity;

use App\Repository\ProductStoreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ProductStoreRepository::class)
 */
class ProductStore
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product.read", "product.write"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"product.read", "product.write"})
     */
    private $store;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="stores")
     */
    private $product;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"product.read", "product.write"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"product.read", "product.write"})
     */
    private $location;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"product.read", "product.write"})
     */
    private $reOrderLevel;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getReOrderLevel(): ?string
    {
        return $this->reOrderLevel;
    }

    public function setReOrderLevel(?string $reOrderLevel): self
    {
        $this->reOrderLevel = $reOrderLevel;

        return $this;
    }
}
