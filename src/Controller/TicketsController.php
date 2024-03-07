<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\ProgrammationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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
 
    // Réservation d'une place 
    #[Route('/tickets/create/{id}', name: 'app_tickets_create')]
    public function createTicket(ProgrammationRepository $prog, EntityManagerInterface $entityManager, Request $request, string $id): Response
    {
        // Récupèration des infos de la programmation lié a l'id reçu en get
        $programmation = $prog->findOneBy(['id'=> $id]);
        // print_r($programmation->getId());

        // A partir de la programmation on accède aux méthodes de l'entité event
        $event= $programmation->getEvent();
        // Récupération des infos de l'utilisateur connecté
        $user=$this->getUser();
        // var_dump($user->getUserFirstname());

        // Instanciation d'un ticket
        $ticket = new Ticket();
        
        // Attribution de valeurs au ticket
        $ticket->setTicketFirstname($user->getUserFirstname());
        $ticket->setTicketLastname($user->getUserLastname());
        $ticket->setTicketNumberPlace('');

        // Création du formulaire
        $form=$this->createForm(TicketType::class,$ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            // Attribution de valeurs au ticket (toutes les valeurs qui ne sont pas présentes dans le formulaire)
            $ticket->setPrice($event->getEventPrice());
            $ticket->setTicketTime(new DateTime('now'));
            $ticket->setTicketDate($programmation->getProgrammationDate());
            $ticket->setTicketPlace($event->getEventPlace());
            $ticket->setProgrammation($programmation);
            $ticket->setUser($user);

            // Enregistrer les infos en BDD
            $entityManager->persist($ticket);
            $entityManager->flush();
            // Redirection vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('tickets/createTicket.html.twig', [
            'controller_name' => 'TicketsController',
            'programmation' => $programmation,
            'user' =>$user,
            'form' => $form->createView()
        ]);
    }

}
