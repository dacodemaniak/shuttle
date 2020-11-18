<?php
namespace App\Helper\ORM;


use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @author Blah
 *  @ORM\HasLifecycleCallbacks
 */

trait TimestampableTrait {
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     * @var datetime
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     * @var datetime
     */
    protected $updatedAt;
    
    public function setCreatedAt($createdAt): self {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    public function getCreatedAt(): ?\DateTime {
        return $this->createdAt;
    }
    
    public function setUpdatedAt(\DateTime $updatedAt): self {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }
    
    public function getUpdatedAt(): ?\DateTime {
        return $this->updatedAt;
    }
}