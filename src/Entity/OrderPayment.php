<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderPaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderPaymentRepository::class)
 */
class OrderPayment
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="payments")
     */
    private $order;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $total;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $received;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $due;

    /**
     * @ORM\ManyToOne(targetEntity=Payment::class)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrde(): ?Order
    {
        return $this->order;
    }

    public function setOrde(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getReceived(): ?string
    {
        return $this->received;
    }

    public function setReceived(string $received): self
    {
        $this->received = $received;

        return $this;
    }

    public function getDue(): ?string
    {
        return $this->due;
    }

    public function setDue(string $due): self
    {
        $this->due = $due;

        return $this;
    }

    public function getType(): ?Payment
    {
        return $this->type;
    }

    public function setType(?Payment $type): self
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
