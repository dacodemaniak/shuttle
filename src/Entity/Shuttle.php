<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Shuttle {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $date;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    private $places;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="shuttle", orphanRemoval=true)
     */
    private $booking;
    
    public function __construct() {
        $this->places = 8;
        $this->customer = new ArrayCollection();
    }
    
    public function getId(): ?int {
        return $this->id;
    }
    
    public function setId(int $id): self {
        $this->id = $id;
        
        return $this;
    }
    
    public function getDate(): ?\DateTime {
        return $this->date;
    }
    
    public function setDate(\DateTime $date): self {
        $this->date = $date;
        
        return $this;
    }
    
    public function setPlaces(int $places): self {
        $this->places = $places;
        
        return $this;
    }
    
    public function getPlaces(): ?int {
        return $this->places;
    }
    
    public function __clone() {
        $this->id = $this->id + 1;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBooking(): Collection
    {
        return $this->booking;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->customer->contains($booking)) {
            $this->booking[] = $booking;
            $booking->setShuttle($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->booking->contains($booking)) {
            $this->booking->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getShuttle() === $this) {
                $booking->setShuttle(null);
            }
        }

        return $this;
    }
    
}

