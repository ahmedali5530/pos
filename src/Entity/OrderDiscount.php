<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderDiscountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDiscountRepository::class)
 */
class OrderDiscount
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="discount", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="orderId")
     */
    private $order;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $rate;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Discount::class)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOder(): ?Order
    {
        return $this->order;
    }

    public function setOder(?Order $order): self
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

    public function getType(): ?Discount
    {
        return $this->type;
    }

    public function setType(?Discount $type): self
    {
        $this->type = $type;

        return $this;
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
}
