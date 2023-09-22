<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
/**
 * @ORM\HasLifecycleCallbacks()  // <-- Add this line to enable lifecycle callbacks
 */
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "float")]
    private ?float $amount = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $paymentMethod = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $paymentDate = null;

    #[ORM\ManyToOne(targetEntity: ParkingSpot::class)]
    #[ORM\JoinColumn(name: "parking_spot_id", referencedColumnName: "id")]
    private ?ParkingSpot $parkingSpot = null;

    #[ORM\ManyToOne(targetEntity: Owner::class)]
    #[ORM\JoinColumn(name: "owner_id", referencedColumnName: "id")]
    private ?Owner $owner = null;

    #[ORM\ManyToOne(targetEntity: Vehicle::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "vehicle_id", referencedColumnName: "id", nullable: true)]
    private ?Vehicle $vehicle = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: "string", length: 7)]  // Format: MM-YYYY
    private ?string $monthYear = null;


    private $rateParkingSpot;
    private $parkingSpotId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float  // Note: Return type is float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static  // Note: Argument type is float
    {
        $this->amount = $amount;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function calculateAmount(): void
    {
        dump('calculateAmount called');  // Debug line to check if the method is being called
        if ($this->parkingSpot !== null) {
            $this->amount = $this->parkingSpot->getRate() * 30;
        }
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }
    
    public function setPaymentDate(?\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }
    
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updatePaymentDate(): void
    {
        $this->setPaymentDate(new \DateTime('now'));
    }

    public function getParkingSpot(): ?ParkingSpot
    {
        return $this->parkingSpot;
    }
    
    public function setParkingSpot(?ParkingSpot $parkingSpot): self
    {
        $this->parkingSpot = $parkingSpot;
    
        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }
    
    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;
    
        return $this;
    }
    

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }
    
    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;
    
        return $this;
    }
    

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getMonthYear(): ?string
    {
        return $this->monthYear;
    }

    public function setMonthYear(string $monthYear): static
    {
        $this->monthYear = $monthYear;

        return $this;
    }
    
    public function getRateFromParkingSpot(): ?float
    {
        return $this->parkingSpot ? $this->parkingSpot->getRate() : null;
    }








    
        public function getRateParkingSpot()
        {
            return $this->rateParkingSpot;
        }
    
        public function getParkingSpotId()
        {
            return $this->parkingSpotId;
        }
}
