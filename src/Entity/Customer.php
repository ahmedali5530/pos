<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @Gedmo\Loggable()
 * @ApiResource(
 *     normalizationContext={"groups"={"customer.read", "time.read", "uuid.read"}}
 * )
 * @ApiFilter(filterClass=SearchFilter::class, properties={"name": "ipartial", "email": "exact", "cnic": "exact", "openingBalance": "exact", "phone": "exact"})
 * @ApiFilter(filterClass=OrderFilter::class, properties={"name", "stores.name", "email", "cnic", "openingBalance", "phone"})
 */
class Customer
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order.read", "customer.read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned()
     * @Groups({"order.read", "customer.read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"order.read", "customer.read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"order.read", "customer.read"})
     */
    private $phone;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"order.read", "customer.read"})
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"order.read", "customer.read"})
     */
    private $address;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"order.read", "customer.read"})
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"order.read", "customer.read"})
     */
    private $lng;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="customer")
     * @Groups({"customer.read"})
     */
    private $orders;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned()
     * @Groups({"order.read", "customer.read"})
     */
    private $cnic;

    /**
     * @ORM\OneToMany(targetEntity=CustomerPayment::class, mappedBy="customer")
     * @Groups({"customer.read"})
     */
    private $payments;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Groups({"order.read", "customer.read"})
     */
    private $openingBalance;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"order.read", "customer.read"})
     */
    private $allowCreditSale;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"order.read", "customer.read"})
     */
    private $creditLimit;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }

    public function getCnic(): ?string
    {
        return $this->cnic;
    }

    public function setCnic(?string $cnic): self
    {
        $this->cnic = $cnic;

        return $this;
    }

    /**
     * @return Collection|CustomerPayment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(CustomerPayment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setCustomer($this);
        }

        return $this;
    }

    public function removePayment(CustomerPayment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getCustomer() === $this) {
                $payment->setCustomer(null);
            }
        }

        return $this;
    }

    public function getOpeningBalance(): ?string
    {
        return $this->openingBalance;
    }

    public function setOpeningBalance(?string $openingBalance): self
    {
        $this->openingBalance = $openingBalance;

        return $this;
    }

    /**
     * @return float
     * @ApiProperty()
     * @Groups({"order.read", "customer.read"})
     */
    public function getSale(): float
    {
        $sale = 0;
        foreach($this->getOrders() as $order){
            foreach($order->getPayments() as $payment){
                if($payment->getType()->getType() === Payment::PAYMENT_TYPE_CREDIT) {
                    $sale += $payment->getReceived();
                }
            }
        }

        return $sale;
    }

    /**
     * @return float
     * @ApiProperty()
     * @Groups({"order.read", "customer.read"})
     */
    public function getPaid(): float
    {
        $paid = 0;
        foreach($this->getPayments() as $payment){
            $paid += $payment->getAmount();
        }

        return $paid;
    }

    /**
     * @return float
     * @ApiProperty()
     * @Groups({"order.read", "customer.read"})
     */
    public function getOutstanding(): float
    {
        return $this->getSale() - $this->getPaid();
    }

    public function getAllowCreditSale(): ?bool
    {
        return $this->allowCreditSale;
    }

    public function setAllowCreditSale(?bool $allowCreditSale): self
    {
        $this->allowCreditSale = $allowCreditSale;

        return $this;
    }

    public function getCreditLimit(): ?string
    {
        return $this->creditLimit;
    }

    public function setCreditLimit(?string $creditLimit): self
    {
        $this->creditLimit = $creditLimit;

        return $this;
    }
}
