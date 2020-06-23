<?php
namespace App\Service;

use App\Entity\Customer;
use Symfony\Component\Form\FormFactoryInterface;
use App\Form\ReservationType;
use Symfony\Component\Form\FormInterface;

final class BookingFormService
{
    /**
     * 
     * @var FormFactoryInterface
     */
    private $formFactory;
    
    public function __construct(FormFactoryInterface $formFactory){
        $this->formFactory = $formFactory;
    }
    
    public function makeForm(Customer $customer = null): FormInterface {
        return $this->formFactory->create(ReservationType::class, $customer);
    }
}

