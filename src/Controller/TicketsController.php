<?php

namespace App\Controller;

use App\Entity\Programmation;
use App\Entity\Ticket;
use App\Repository\ProgrammationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TicketsController extends AbstractController
{
    #[Route('/tickets', name: 'app_tickets')]
    public function index(): Response
    {
        return $this->render('tickets/index.html.twig', [
            'controller_name' => 'TicketsController',
        ]);
    }

    #[Route('/tickets/create/{id}', name: 'app_tickets')]
    public function createTicket(ProgrammationRepository $prog, string $id): Response
    {
        $programmation = $prog->findOneBy(['id'=> $id]);
        // print_r($programmation->getId());
        $user=$this->getUser();
        var_dump($user->getUserFirstname());
        $ticket = new Ticket;

        $ticket->setPrice('45');
        $ticket->setTicketDate(new DateTime('now'));
        $ticket->setTicketFirstname($user->getUserFirstname());
        $ticket->setTicketLastname($user->getUserLastname());
        $ticket->setTicketTime();
        $ticket->setTicketPlace();
        $ticket->setTicketNumberPlace();
        $ticket->setProgrammation();
        $ticket->setUser();



        return $this->render('tickets/createTicket.html.twig', [
            'controller_name' => 'TicketsController',
            'programmation' => $programmation,
            'user' =>$user
        ]);
    }

}
