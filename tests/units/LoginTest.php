<?php

namespace App\Tests\Units;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLogin()
{
    // Création du client
    $client = static::createClient();

    // Requête pour accéder à la page de connexion
    $client->request('GET', '/login');

    // Vérification du statut de la réponse (HTTP 200 OK)
    $this->assertResponseStatusCodeSame(Response::HTTP_OK);
}

public function testIfH1Exists()
{
    // Création du client
    $client = static::createClient();

    // Requête pour accéder à la page de connexion
    $client->request('GET', '/login');

    // Vérifit si l'élément h1 existe sur la page et contient le texte spécifié
    $this->assertSelectorTextContains('h1', text : 'Veuillez vous connecter');
}

}
