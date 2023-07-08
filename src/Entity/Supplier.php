<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ORM\Entity(repositoryClass=SupplierRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"supplier.read", "time.read", "uuid.read"}}
 * )
 * @ApiFilter(filterClass=SearchFilter::class, properties={"name": "ipartial", "phone": "ipartial", "email": "partial", "openingBalance": "exact"})
 * @ApiFilter(filterClass=OrderFilter::class, properties={"name", "phone", "email", "openingBalance"})
 */
class Supplier
{
    use ActiveTrait;
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"supplier.read", "product.read", "purchase.read", "purchaseOrder.read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"supplier.read", "product.read", "purchase.read", "purchaseOrder.read"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"supplier.read", "product.read", "purchase.read", "purchaseOrder.read"})
     * @Assert\NotBlank()
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"supplier.read", "product.read", "purchase.read", "purchaseOrder.read"})
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"supplier.read", "product.read", "purchase.read", "purchaseOrder.read"})
     */
    private $whatsApp;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"supplier.read", "product.read", "purchase.read", "purchaseOrder.read"})
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"supplier.read", "product.read", "purchase.read", "purchaseOrder.read"})
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class)
     * @Groups({"supplier.read", "product.read", "purchase.read", "purchaseOrder.read"})
     */
    private $media;

    /**
     * @ORM\ManyToMany(targetEntity=Store::class)
     * @Groups({"supplier.read"})
     * @Assert\NotBlank()
     */
    private $stores;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, nullable=true)
     * @Groups({"supplier.read", "product.read", "purchase.read", "purchaseOrder.read"})
     * @Assert\NotBlank()
     */
    private $openingBalance;

    /**
     * @ApiSubresource()
     * @ORM\OneToMany(targetEntity=Purchase::class, mappedBy="supplier")
     * @Groups({"supplier.read"})
     */
    private $purchases;

    /**
     * @ApiSubresource()
     * @ORM\OneToMany(targetEntity=PurchaseOrder::class, mappedBy="supplier", orphanRemoval=true)
     * @Groups({"supplier.read"})
     */
    private $purchaseOrders;

    /**
     * @ApiSubresource()
     * @ORM\OneToMany(targetEntity=SupplierPayment::class, mappedBy="supplier", orphanRemoval=true)
     * @Groups({"supplier.read"})
     */
    private $payments;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->stores = new ArrayCollection();
        $this->purchases = new ArrayCollection();
        $this->purchaseOrders = new ArrayCollection();
        $this->payments = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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

    public function getWhatsApp(): ?string
    {
        return $this->whatsApp;
    }

    public function setWhatsApp(?string $whatsApp): self
    {
        $this->whatsApp = $whatsApp;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

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

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return Collection|Store[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Store $store): self
    {
        if (!$this->stores->contains($store)) {
            $this->stores[] = $store;
        }

        return $this;
    }

    public function removeStore(Store $store): self
    {
        $this->stores->removeElement($store);

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
     * @return Collection|Purchase[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setSupplier($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getSupplier() === $this) {
                $purchase->setSupplier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PurchaseOrder[]
     */
    public function getPurchaseOrders(): Collection
    {
        return $this->purchaseOrders;
    }

    public function addPurchaseOrder(PurchaseOrder $purchaseOrder): self
    {
        if (!$this->purchaseOrders->contains($purchaseOrder)) {
            $this->purchaseOrders[] = $purchaseOrder;
            $purchaseOrder->setSupplier($this);
        }

        return $this;
    }

    public function removePurchaseOrder(PurchaseOrder $purchaseOrder): self
    {
        if ($this->purchaseOrders->removeElement($purchaseOrder)) {
            // set the owning side to null (unless already changed)
            if ($purchaseOrder->getSupplier() === $this) {
                $purchaseOrder->setSupplier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SupplierPayment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(SupplierPayment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setSupplier($this);
        }

        return $this;
    }

    public function removePayment(SupplierPayment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getSupplier() === $this) {
                $payment->setSupplier(null);
            }
        }

        return $this;
    }

    /**
     * @return float
     * @ApiProperty()
     * @Groups({"supplier.read"})
     */
    public function getPurchaseTotal(): float
    {
        $sale = 0;
        foreach($this->getPurchases() as $purchase){
            if(
                $purchase->getPaymentType() !== null &&
                $purchase->getPaymentType()->getType() === Payment::PAYMENT_TYPE_CREDIT
            ) {
                $sale += $purchase->getTotal();
            }
        }

        return $sale + $this->getOpeningBalance();
    }

    /**
     * @return float
     * @ApiProperty()
     * @Groups({"supplier.read"})
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
     * @Groups({"supplier.read"})
     */
    public function getOutstanding(): float
    {
        return $this->getPurchaseTotal() - $this->getPaid();
    }
}
