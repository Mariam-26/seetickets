<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EventRepository $events, UserRepository $users): Response
    {
        $e=$events->findAll();
        $u=$users->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'events'=> $e,
            'users'=>$u
        ]);
    }
}
