<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderPaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderPaymentRepository::class)
 * @Gedmo\Loggable()
 * @ApiResource()
 */
class OrderPayment
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
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="payments")
     * @Gedmo\Versioned()
     * @Groups({"order.read"})
     */
    private $order;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     */
    private $total;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     */
    private $received;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     */
    private $due;

    /**
     * @ORM\ManyToOne(targetEntity=Payment::class)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
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
