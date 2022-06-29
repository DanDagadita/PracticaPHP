<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Location::class, inversedBy: 'stations')]
    #[ORM\JoinColumn(nullable: false)]
    private $location;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'float')]
    private $power;

    #[ORM\OneToOne(mappedBy: 'station', targetEntity: Booking::class, cascade: ['persist', 'remove'])]
    private $booking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPower(): ?float
    {
        return $this->power;
    }

    public function setPower(float $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(Booking $booking): self
    {
        // set the owning side of the relation if necessary
        if ($booking->getStation() !== $this) {
            $booking->setStation($this);
        }

        $this->booking = $booking;

        return $this;
    }
}
