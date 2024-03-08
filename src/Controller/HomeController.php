<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(SessionInterface $session,EventRepository $events, CategoryRepository $category): Response
    {

        $arrayOfFavEvents=[];
        if($session->get('favoris')){
            
            $favoris=$session->get('favoris');

            $counter=0;
            foreach($favoris as $favori){
                $arrayOfFavEvents[$counter]=$events->findOneBy(['id'=>$favori]);
                $counter++;
            }
        }

        $event=$events->findAll();
        $C=$category->findAll();
        $Category=array_slice($C,1,9);
        $topEvent = array_slice($event,0,3);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'events'=> $topEvent,
            'event'=> $event,
            "category"=>$Category,
            'favoris'=>$arrayOfFavEvents

            
        ]);
    }
}
 