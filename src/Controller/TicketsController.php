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

     // VOIRE UN TICKET EN DETAIL /tickets/{id}
     #[Route('/tickets/{id}', name: 'app_ticket_details', methods: ['GET'])]
     public function detail($id, TicketRepository $ticketRepository): Response
     {
         $ticket = $$ticketRepository->findOneBy(['id' => $id]);
         
      return  $this->render('tickets/detail.html.twig', [
           'ticket' => $ticket
     ]);
     }
 
}
