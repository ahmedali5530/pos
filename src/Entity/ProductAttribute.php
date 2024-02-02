<?php

namespace App\Entity;

use App\Repository\ProductAttributeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductAttributeRepository::class)
 */
class ProductAttribute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product.read", "product.write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product.read", "product.write"})
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"product.read", "product.write"})
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product.read", "product.write"})
     */
    private $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"product.read", "product.write"})
     */
    private $indexOnSearch;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIndexOnSearch(): ?bool
    {
        return $this->indexOnSearch;
    }

    public function setIndexOnSearch(?bool $indexOnSearch): self
    {
        $this->indexOnSearch = $indexOnSearch;

        return $this;
    }
}
