<?php

namespace App\Controller;

use App\Entity\Programmation;
use App\Repository\EventRepository;
use App\Repository\ProgrammationRepository;
use App\Entity\Event;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventsController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function event(EventRepository $events): Response
    {
        $e = $events->findAll();
        return $this->render('events/index.html.twig', [
            'controller_name' => 'EventsController',
            'events' => $e
            

        ]);
    }

    #[Route('/topevents', name: 'app_topevents')]
    public function topevent(TicketRepository $tickets): Response
    {   
        $events=$tickets->getTop20Events();
        return $this->render('events/top20.html.twig', [
            'controller_name' => 'EventsController',
            'top20'=> $events
        ]);
    }

    #[Route('/search_Result', name: 'search_Result')]
    public function searchEvent(Request $request, EventRepository $events): Response
    {
        $query = $request->query->get('query');
        // Traitez la requête de recherche comme vous le souhaitez, par exemple, recherchez dans la base de données
        $results = $events->findEventByName($query);


        return $this->render('events/search_result.html.twig', [
            // Passez d'autres données de résultat de recherche à votre template si nécessaire
            'events' => $results,
            'query' => $query

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
