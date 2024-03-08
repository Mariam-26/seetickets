<?php

namespace App\Tests\Units;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
  public function testIfLoginIsSuccessful()
  {
    // Création du client
    $client = static::createClient();

    // Faire une requête GET vers la page de connexion
    $client->request(method: 'GET', uri: '/login');

    // Vérifier le code de réponse
    $this->assertResponseStatusCodeSame(expectedCode: Response::HTTP_OK);

    // Vérifier qu'il n'y a pas d'élément avec la classe "alert alert-danger"
    $this->assertSelectorNotExists(selector: 'alert alert-danger');
  }
}
