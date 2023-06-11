<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderTaxRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderTaxRepository::class)
 * @Gedmo\Loggable()
 * @ApiResource()
 */
class OrderTax
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order.read","customer.read"})
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="tax", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="orderId")
     * @Gedmo\Versioned()
     */
    private $order;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     */
    private $rate;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Tax::class)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getType(): ?Tax
    {
        return $this->type;
    }

    public function setType(?Tax $type): self
    {
        $this->type = $type;

        return $this;
    }
}
