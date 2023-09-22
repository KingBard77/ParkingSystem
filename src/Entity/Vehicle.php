<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $licensePlate = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\ManyToOne(targetEntity: Owner::class)]
    #[ORM\JoinColumn(name: "owner_id", referencedColumnName: "id", nullable: true)]
    private ?Owner $owner = null;  // Change the type to ?Owner

    // #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    // #[ORM\OneToOne(targetEntity: ParkingSpot::class, cascade: ['persist', 'remove'])]
    #[ORM\OneToOne(targetEntity: ParkingSpot::class, inversedBy: "vehicle")]
    private ?ParkingSpot $parkingSpot;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function __toString(): string
    {
        return $this->licensePlate;  // Or any other property that uniquely identifies the object
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate): static
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getOwner(): ?Owner  // Change the return type to ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): static  // Change the parameter type to ?Owner
    {
        $this->owner = $owner;

        return $this;
    }

    public function getParkingSpot(): ?ParkingSpot
    {
        return $this->parkingSpot;
    }

    public function setParkingSpot(?ParkingSpot $parkingSpot): static
    {
        $this->parkingSpot = $parkingSpot;
        
        // set (or unset) the owning side of the relation
        if (null !== $parkingSpot) {
            $parkingSpot->setVehicle($this);
        }
    
        return $this;
    }
}
