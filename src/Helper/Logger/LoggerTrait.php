<?php
namespace App\Helper\Logger;

use Psr\Log\LoggerInterface;

trait LoggerTrait {
    /**
     * 
     * @var LoggerInterface
     */
    protected $logger;
    
    /**
     * @required
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void {
        $this->logger = $logger;
    }
}

