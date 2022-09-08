<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 * @UniqueEntity(fields={"orderId"})
 * @Gedmo\Loggable()
 */
class Order
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned()
     */
    private $orderId;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="orders")
     * @Gedmo\Versioned()
     */
    private $customer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Gedmo\Versioned()
     */
    private $isSuspended;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Gedmo\Versioned()
     */
    private $isDeleted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Gedmo\Versioned()
     */
    private $isReturned;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Gedmo\Versioned()
     */
    private $isDispatched;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @Gedmo\Versioned()
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="order", cascade={"persist", "remove"})
     */
    private $items;

    /**
     * @var OrderDiscount
     * @ORM\OneToOne(targetEntity=OrderDiscount::class, mappedBy="order", cascade={"persist", "remove"})
     * @Gedmo\Versioned()
     */
    private $discount;

    /**
     * @var OrderTax
     * @ORM\OneToOne(targetEntity=OrderTax::class, mappedBy="order", cascade={"persist", "remove"})
     * @Gedmo\Versioned()
     */
    private $tax;

    /**
     * @ORM\OneToMany(targetEntity=OrderPayment::class, mappedBy="order", cascade={"persist", "remove"})
     */
    private $payments;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Versioned()
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity=Order::class)
     * @ORM\JoinColumn(nullable=true)
     * @Gedmo\Versioned()
     */
    private $returnedFrom;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(?int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getIsSuspended(): ?bool
    {
        return $this->isSuspended;
    }

    public function setIsSuspended(?bool $isSuspended): self
    {
        $this->isSuspended = $isSuspended;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getIsReturned(): ?bool
    {
        return $this->isReturned;
    }

    public function setIsReturned(?bool $isReturned): self
    {
        $this->isReturned = $isReturned;

        return $this;
    }

    public function getIsDispatched(): ?bool
    {
        return $this->isDispatched;
    }

    public function setIsDispatched(?bool $isDispatched): self
    {
        $this->isDispatched = $isDispatched;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDiscount(): ?OrderDiscount
    {
        return $this->discount;
    }

    public function setDiscount(?OrderDiscount $discount): self
    {
        // unset the owning side of the relation if necessary
        if ($discount === null && $this->discount !== null) {
            $this->discount->setOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($discount !== null && $discount->getOrder() !== $this) {
            $discount->setOrder($this);
        }

        $this->discount = $discount;

        return $this;
    }

    /**
     * @return Collection|OrderProduct[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderProduct $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setOrder($this);
        }

        return $this;
    }

    public function removeItem(OrderProduct $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrder() === $this) {
                $item->setOrder(null);
            }
        }

        return $this;
    }

    public function getTax(): ?OrderTax
    {
        return $this->tax;
    }

    public function setTax(?OrderTax $tax): self
    {
        // unset the owning side of the relation if necessary
        if ($tax === null && $this->tax !== null) {
            $this->tax->setOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($tax !== null && $tax->getOrder() !== $this) {
            $tax->setOrder($this);
        }

        $this->tax = $tax;

        return $this;
    }

    /**
     * @return Collection|OrderPayment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(OrderPayment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setOrder($this);
        }

        return $this;
    }

    public function removePayment(OrderPayment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getOrder() === $this) {
                $payment->setOrder(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getReturnedFrom(): ?self
    {
        return $this->returnedFrom;
    }

    public function setReturnedFrom(?self $returnedFrom): self
    {
        $this->returnedFrom = $returnedFrom;

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
}
