<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;

class PublishController extends AbstractController
{
    /**
     * @Route("/message", name="publishMessage")
     */
    public function index(MessageBusInterface $bus, PublisherInterface $publisher, Request $request)
    {
        // Create an update (as an envelop)
        $update = new Update(
            'https://example.com/my-private-topic',
            json_encode([
                'message' => $request->request->get('message')
            ])
        );
        
        // Send the Update in the bus
        $bus->dispatch($update);
        //$publisher($update);
        
        //return $this->redirectToRoute('home');

    }
}
