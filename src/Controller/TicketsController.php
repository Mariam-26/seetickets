<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TicketsController extends AbstractController
{
    #[Route('/tickets', name: 'app_tickets')]
    public function index(TicketRepository $tickets): Response
    {
        $t=$tickets->findAll();
        return $this->render('tickets/index.html.twig', [
            'controller_name' => 'TicketsController',
            'tickets'=>$t
        ]);
    }
}
