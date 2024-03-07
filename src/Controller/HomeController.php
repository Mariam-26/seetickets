<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EventRepository $events, CategoryRepository $category): Response
    {

        $couleurs = ["#E5007D","info","danger","success","secondary","light","muted"];
        $event=$events->findAll();
        $Category=$category->findAll();
        $topEvent = array_slice($event,0,3);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'events'=> $topEvent,
            'event'=> $event,
            "category"=>$Category,
            "couleur" => $couleurs
            
        ]);
    }
}
 