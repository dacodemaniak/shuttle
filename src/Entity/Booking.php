<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Shuttle::class, inversedBy="booking")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shuttle;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\Column(type="integer")
     */
    private $places;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShuttle(): ?Shuttle
    {
        return $this->shuttle;
    }

    public function setShuttle(?Shuttle $shuttle): self
    {
        $this->shuttle = $shuttle;

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

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }
}
