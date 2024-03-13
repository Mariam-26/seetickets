<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class ForgotPasswordController extends AbstractController
{
    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(Request $request, MailerInterface $mailer, UserRepository $userRepository): Response
    {
       // L'affichage du formulaire de renitialisation
       return $this->render('forgot_password/index.html.twig', [
       ]);
   }
}
