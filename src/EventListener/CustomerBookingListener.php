<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Response;

use App\Helper\Logger\LoggerTrait;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

class CustomerBookingListener implements EventSubscriberInterface
{
    use LoggerTrait;
    
    public static function getSubscribedEvents() {
        return [
            RequestEvent::class => 'onKernelRequest',
            ControllerArgumentsEvent::class => 'onKernelControllerArguments'
        ];
    }
    
    public function onKernelRequest(RequestEvent $event) {
        $this->logger->info('Before controller was resolved');
        $request = $event->getRequest();
        
        $resaId = $request->get('resa');
        $customerId = $request->get('customer');
        
        $event->setResponse(new Response('Sorry... ' . $resaId . 'isClosed', 403));
        
        
        //dd($event);
    }
    
    public function onKernelControllerArguments(ControllerArgumentsEvent $event): void {
        dd($event);
    }
}

