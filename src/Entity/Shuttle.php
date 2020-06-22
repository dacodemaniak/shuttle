<?php
namespace App\Entity;

final class Shuttle {
    /**
     * 
     * @var int
     */
    private $id;
    
    /**
     * 
     * @var \DateTime
     */
    private $date;
    
    /**
     * 
     * @var int
     */
    private $places;
    
    public function __construct() {
        $this->places = 8;
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
    
}

