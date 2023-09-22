<?php

namespace App\Entity;

use App\Repository\ParkingSpotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParkingSpotRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class ParkingSpot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Status = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\Column(length: 255)]
    private ?string $Zone = null;

    #[ORM\Column]
    private ?float $Rate = null;

    #[ORM\Column(type: "datetime_immutable")]
    private ?\DateTimeImmutable $CreateAt = null;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private ?\DateTimeImmutable $UpdateAt = null;

    #[ORM\OneToOne(targetEntity: Vehicle::class, mappedBy: "parkingSpot", cascade: ["persist", "remove"])]
    private ?Vehicle $vehicle;
    
    public function __construct()
    {
        $this->Status = 'Available';
    }
    
    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }
    
    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;
    
        // Update the status based on the vehicle association
        if ($vehicle === null) {
            $this->Status = 'Available';
        } else {
            $this->Status = 'Unavailable';
        }
    
        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;
        
        // Update the rate based on the type
        $this->updateRateBasedOnType();
        
        return $this;
    }

    // Implement updateRate {Type}
    private function updateRateBasedOnType(): void
    {
        switch ($this->Type) {
            case 'Basic':
                $this->Rate = 100.0;
                break;
            case 'Standard':
                $this->Rate = 130.0;
                break;
            default:
                $this->Rate = 160.0;
                break;
        }
    }

    public function getZone(): ?string
    {
        return $this->Zone;
    }

    public function setZone(string $Zone): static
    {
        $this->Zone = $Zone;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->Rate;
    }

    public function setRate(float $Rate): static
    {
        $this->Rate = $Rate;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->CreateAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if ($this->CreateAt === null) {
            $this->CreateAt = new \DateTimeImmutable();
        }
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->UpdateAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->UpdateAt = new \DateTimeImmutable();
    }
}
