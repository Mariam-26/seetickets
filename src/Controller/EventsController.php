<?php

namespace App\Controller;

use App\Entity\Programmation;
use App\Repository\EventRepository;
use App\Repository\ProgrammationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventsController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function index(EventRepository $events): Response
    {
        $e = $events->findAll();
        return $this->render('events/index.html.twig', [
            'controller_name' => 'EventsController',
            'events' => $e

        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(): Response
    {
        return $this->render('events/search.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }

    #[Route('/fav', name: 'app_favorites')]
    public function favorites(): Response
    {
        return $this->render('events/favorites.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }

    // VOIRE UN EVENEMENT EN DETAIL
    #[Route('/event_details/{id}', name: 'app_event_details', methods: ['GET'])]
    public function detail(ProgrammationRepository $programmationRepository, $id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->findOneBy(['id' => $id]);
        //dd($event);
        $programmations = $programmationRepository->findBy(['event' => $event]);
        // dd($programmations);

        // Si l'évènement existe j'envoie les données à la vue
        return  $this->render('events/detail.html.twig', [
            // 'form' => $form->createView(), 
            'event' => $event,
            'programmations' => $programmations,
        ]);
    }

    
}
