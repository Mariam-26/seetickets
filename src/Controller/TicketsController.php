<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\ProgrammationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

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
    public function createTicket(ProgrammationRepository $prog, EntityManagerInterface $entityManager, string $id): Response
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
        $ticket->setTicketTime(new DateTime('now'));
        $ticket->setTicketPlace('Salle B');
        $ticket->setTicketNumberPlace('A125');
        $ticket->setProgrammation($programmation);
        $ticket->setUser($user);

        $entityManager->persist($ticket);
        $entityManager->flush();


        return $this->render('tickets/createTicket.html.twig', [
            'controller_name' => 'TicketsController',
            'programmation' => $programmation,
            'user' =>$user
        ]);
    }

}
