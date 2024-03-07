<?php

namespace App\Controller;

use App\Entity\Programmation;
use App\Repository\EventRepository;
use App\Repository\ProgrammationRepository;
use App\Entity\Event;
use App\Repository\CategoryRepository;
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


    #[Route('/events/{category}', name: 'app_events')]
    public function eventCategory(EventRepository $events, $category): Response
    {
        $e = $events->findEventByCategory(['category_id' => $category]);
        $categoryName = $events->findCategory(['category_id' => $category]);
        return $this->render('events/event_category.html.twig', [
            'controller_name' => 'EventsController',
            'events' => $e,
            "categoryName" => $categoryName

        ]);

    }
    
    
    /**
     * route qui permet d'afficher le résultat d'une recherche
     *
     * @param Request $request
     * @param EventRepository $events
     * @return Response
     */
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


    /**
     * route qui permet d'aller sur la barre de recherche
     *
     * @return Response
     */
    #[Route('/search', name: 'app_search')]
    public function search(EventRepository $events,CategoryRepository $categories): Response
    {
        $e = $events->findAll();
        $event = array_slice($e,10,6);

        $c = $categories->findAll();
        $category = array_slice($c,0,4);

        return $this->render('events/search.html.twig', [
            'controller_name' => 'EventsController',
            "events" => $event,
            "categories" => $category
        ]);
    }

    #[Route('/fav', name: 'app_favorites')]
    public function favorites(): Response
    {
        return $this->render('events/favorites.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }



    /**
     *     // Route qui permet de voir un evenement en détail.

     */
    #[Route('/event_details/{id}', name: 'app_event_details', methods: ['GET'])]
    public function detail(ProgrammationRepository $programmationRepository, $id, EventRepository $eventRepository /* INJECTION DE DEPENDANCE DE MES REPOSITORY (PROGRAMME ET EVENT) */): Response
    {
        // RECHERCHE D'UN EVENEMENT PAR SON ID
        $event = $eventRepository->findOneBy(['id' => $id]);
        // RECHERCHE DES PROGRAMMATIONS LIEES A UN EVENEMENT
        $programmations = $programmationRepository->findBy(['event' => $event]);
        // J'ENVOIE SES DONNEES A LA VUE
        return  $this->render('events/detail.html.twig', [
            // JE METS LES INFOS SUR L'EVENEMENT A LA VARIALE ($event) DANS TWIG
            'event' => $event,
            // JE METS LES INFOS SUR LA PROGRAMMATION A LA VARIALE ($programmations) DANS TWIG
            'programmations' => $programmations,
        ]);
    }
}
