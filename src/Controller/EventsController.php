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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class EventsController extends AbstractController
{
    #[Route('/events', name: 'events')]
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
        $event = $events->findAll();

        $e = $events->findEventByCategory(['category_id' => $category]);
        $categoryName = $events->findCategory(['category_id' => $category]);
        return $this->render('events/event_category.html.twig', [
            'controller_name' => 'EventsController',
            'events' => $e,
            'event' => $event,

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
    #[Route('/search_result', name: 'search_result')]
    public function searchEvent(Request $request, EventRepository $events): Response
    {
        $query = $request->query->get('query');



        if (empty($query)) {

            return $this->render('events/search_result.html.twig', [
                // Passez d'autres données de résultat de recherche à votre template si nécessaire
                'events' => [],
                'query' => $query,
                "message" => "",


            ]);
        } else if (preg_match('/^[a-zA-Z]+$/', $query)) {

            // Traitez la requête de recherche comme vous le souhaitez, par exemple, recherchez dans la base de données
            $results = $events->findEventByName($query);


            return $this->render('events/search_result.html.twig', [
                // Passez d'autres données de résultat de recherche à votre template si nécessaire
                "message" => "",

                'events' => $results,
                'query' => $query

            ]);
        } else {




            return $this->render('events/search_result.html.twig', [
                // Passez d'autres données de résultat de recherche à votre template si nécessaire
                "message" => "veuillez entrez des champs valides",
                'events' => [],
                'query' => $query


            ]);
        }
    }

    /**
     * route qui permet d'aller sur la barre de recherche
     *
     * @return Response
     */
    #[Route('/search', name: 'app_search')]
    public function search(EventRepository $events, CategoryRepository $categories): Response
    {
        $e = $events->findAll();
        $event = array_slice($e, 10, 6);

        $c = $categories->findAll();
        $category = array_slice($c, 0, 4);

        return $this->render('events/search.html.twig', [
            'controller_name' => 'EventsController',
            "events" => $event,
            "categories" => $category
        ]);
    }

    #[Route('/fav', name: 'app_favorites')]
    public function favorites(SessionInterface $session, EventRepository $events): Response
    {
        $arrayOfFavEvents = [];
        if ($session->get('favoris')) {

            $favoris = $session->get('favoris');

            $counter = 0;
            foreach ($favoris as $favori) {
                $arrayOfFavEvents[$counter] = $events->findOneBy(['id' => $favori]);
                $counter++;
            }
        }


        return $this->render('events/favorites.html.twig', [
            'favoris' => $arrayOfFavEvents
        ]);
    }

    #[Route('/fav/add/{id}', name: 'app_add_favorite')]
    public function addToFav(SessionInterface $session, string $id): Response
    {
        $favoris = $session->get('favoris');
        if (!$session->get('favoris')) {
            $favoris = [];
            array_push($favoris, $id);
            $session->set('favoris', $favoris);
        } elseif ($session->get('favoris') && in_array($id, $favoris) == false) {
            $favoris = $session->get('favoris');
            array_push($favoris, $id);
            $session->set('favoris', $favoris);
        }

        return $this->redirectToRoute('app_favorites');
    }

    #[Route('/fav/remove/{id}', name: 'app_remove_favorite')]
    public function removeFav(SessionInterface $session, string $id): Response
    {
        $favoris = $session->get('favoris');
        foreach (array_keys($favoris, $id, true) as $key) {
            unset($favoris[$key]);
        }
        $session->set('favoris', $favoris);

        return $this->redirectToRoute('app_favorites');
    }


    // VOIR UN EVENEMENT EN DETAIL
    #[Route('/event_details/{id}', name: 'app_event_details', methods: ['GET'])]
    public function detail(ProgrammationRepository $programmationRepository, $id, EventRepository $eventRepository /* Injection de dépendance de mes repository ( programmation et event) */): Response
    {
        // Recherche d'un évènement par son id
        $event = $eventRepository->findOneBy(['id' => $id]);
        // Recherche des programmations liées à un évènement
        $programmations = $programmationRepository->findBy(['event' => $event]);
        // J'envoie des données à la vue
        return  $this->render('events/detail.html.twig', [
            // Je mets des infos à la variable ($event)
            'event' => $event,
            // Je mets des infos à la variable ($programmations)
            'programmations' => $programmations,
        ]);
    }
}
