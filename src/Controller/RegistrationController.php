<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
         // Instaciation de l'entité User
         $user = new User();
        
         // Injection de dépendance pour création le formulaire de registation
         $form = $this->createForm(RegistrationFormType::class, $user);
         
         // Traitement de la soumission du formulaire
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             // Récupération des mots de passe saisis dans le formulaire
             $password1 = $form->get('plainPassword')->getData();
             $password2 = $form->get('plainPassword_second')->getData();
             
             //Comparaison des deux mots de passe
             if ($password1 === $password2) {
                 // Hashage du mot de passe
                 $user->setPassword(
                     $userPasswordHasher->hashPassword(
                         $user,
                         $password1
                     )
                 );
 
                 // Activation du compte utilisateur
                 $user->setIsActived(true);
 
                 // Persistance de l'utilisateur en base de données
                 $entityManager->persist($user);
                 $entityManager->flush();

                 
                 // Authentification de l'utilisateur après l'enregistrement
                 return $userAuthenticator->authenticateUser(
                     $user,
                     $authenticator,
                     $request
                    );
            } else {
                $this->addFlash(
                    'error',
                    'Erreur de saisie'
                ); /* affiche le message */
            }
        }
 
         // Rendu du template de formulaire d'inscription
         return $this->render('registration/register.html.twig', [
             'registrationForm' => $form->createView(),
         ]);
     }
}


