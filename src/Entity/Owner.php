<?php

namespace App\Entity;

use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OwnerRepository::class)]
class Owner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $EmployeeID = null;

    #[ORM\Column(length: 255)]
    private ?string $OwnerName = null;

    #[ORM\Column(length: 255)]
    private ?string $ContactNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: "owner")]
    private $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->OwnerName ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeID(): ?string
    {
        return $this->EmployeeID;
    }

    public function setEmployeeID(string $EmployeeID): static
    {
        $this->EmployeeID = $EmployeeID;

        return $this;
    }

    public function getOwnerName(): ?string
    {
        return $this->OwnerName;
    }

    public function setOwnerName(string $OwnerName): static
    {
        $this->OwnerName = $OwnerName;

        return $this;
    }

    public function getContactNumber(): ?string
    {
        return $this->ContactNumber;
    }

    public function setContactNumber(string $ContactNumber): static
    {
        $this->ContactNumber = $ContactNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->setOwner($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getOwner() === $this) {
                $vehicle->setOwner(null);
            }
        }

        return $this;
    }
}
