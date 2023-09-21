<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderDiscountRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=OrderDiscountRepository::class)
 * @Gedmo\Loggable()
 * @ApiResource()
 */
class OrderDiscount
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
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="discount", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="orderId")
     * @Gedmo\Versioned()
     */
    private $order;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     */
    private $rate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"order.read","customer.read"})
     */
    private $rateType;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Discount::class)
     * @Gedmo\Versioned()
     * @Groups({"order.read","customer.read"})
     * @ORM\JoinColumn(onDelete="set null")
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(?string $rate): self
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

    public function getRateType(): ?string
    {
        return $this->rateType;
    }

    public function setRateType(?string $rateType): self
    {
        $this->rateType = $rateType;

        return $this;
    }
}
