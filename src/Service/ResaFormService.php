<?php
namespace App\Service;

use Symfony\Component\Form\FormInterface;
use App\Form\ReservationType;
use App\Entity\Customer;
use App\Controller\ShuttleController;

final class ResaFormService
{

    /**
     * 
     * @var FormInterface
     */
    private $form;
    
    public function __construct(){
        
    }
    
    public function create(ShuttleController $controller) {
        return $controller->createForm(ReservationType::class, new Customer());
    }
}

