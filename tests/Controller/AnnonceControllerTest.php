<?php

namespace App\Tests\Controller;

use App\Entity\Annonce\AnnonceAutomobile;
use App\Entity\Annonce\AnnonceGenerique;
use App\Repository\Annonce\AnnonceAutomobileRepository;
use App\Repository\Annonce\AnnonceGeneriqueRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnnonceControllerTest extends WebTestCase
{
    public function testIndexRouteStatus200(): void
    {
        $client = static::createClient();
        $client->request('GET', '/annonces');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateRouteStatus200(): void
    {
        $client = static::createClient();
        $kernel = self::$kernel;
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        /** @var AnnonceGeneriqueRepository $annonceGeneriqueRepository */
        $annonceGeneriqueRepository = $em->getRepository(AnnonceGenerique::class);
        /** @var AnnonceAutomobileRepository $annonceAutomobileRepository */
        $annonceAutomobileRepository = $em->getRepository(AnnonceAutomobile::class);
        $countAnnonceAutomobile = count($annonceAutomobileRepository->findAll());
        $countAnnonceGenerique = count($annonceGeneriqueRepository->findAll());
        $body = [
            "modele" => "Rs4",
            "titre" => "vend audi Rs4",
            "categorie" => "Automobile",
            "contenu" => "Bonjour je vend une audi Rs4 quasiment neuve (10 000 km) de 2022."
        ];
        $client->request('POST', '/annonce', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($body));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount($countAnnonceAutomobile + 1, $annonceAutomobileRepository->findAll());
        $body = [
            "titre" => "Appartement 120m²",
            "categorie" => "Immobilier",
            "contenu" => "Bonjour je met en vente mon appartement de 120m²"
        ];
        $client->request('POST', '/annonce', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($body));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount($countAnnonceGenerique + 1, $annonceGeneriqueRepository->findAll());
    }

    public function testUpdateRouteStatus200(): void
    {
        $client = static::createClient();
        $kernel = self::$kernel;
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        /** @var AnnonceGeneriqueRepository $annonceGeneriqueRepository */
        $annonceGeneriqueRepository = $em->getRepository(AnnonceGenerique::class);
        /** @var AnnonceAutomobileRepository $annonceAutomobileRepository */
        $annonceAutomobileRepository = $em->getRepository(AnnonceAutomobile::class);
        $allAutomobiles = $annonceAutomobileRepository->findAll();
        $allGenerique = $annonceGeneriqueRepository->findAll();
        $lastAutomobile = end($allAutomobiles);
        $lastGenerique = end($allGenerique);
        $countAnnonceAutomobile = count($allAutomobiles);
        $countAnnonceGenerique = count($allGenerique);
        $idAutomobile = (string)$lastAutomobile->getId();
        $idGenerique = (string)$lastGenerique->getId();
        $body = [
            "modele" => "Rs4",
            "titre" => "Bonjour je vend mon audi Rs4",
            "categorie" => "Automobile",
            "contenu" => "Bonjour je vend une audi Rs4 quasiment neuve (10 000 km) de 2022."
        ];
        $client->request(
            'PUT',
            '/annonce/' . $idAutomobile,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($body)
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount($countAnnonceAutomobile, $allAutomobiles);
        $arrayBody = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame("Bonjour je vend mon audi Rs4", $arrayBody["titre"]);

        $body = [
            "titre" => "Appartement 122m²",
            "categorie" => "Immobilier",
            "contenu" => "Bonjour je met en vente mon appartement de 120m²"
        ];
        $client->request(
            'PUT',
            '/annonce/' . $idGenerique,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($body)
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount($countAnnonceGenerique, $allGenerique);
        $arrayBody = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame("Appartement 122m²", $arrayBody["titre"]);
    }

    public function testRemoveRouteStatus200(): void
    {
        $client = static::createClient();
        $kernel = self::$kernel;
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        /** @var AnnonceGeneriqueRepository $annonceGeneriqueRepository */
        $annonceGeneriqueRepository = $em->getRepository(AnnonceGenerique::class);
        /** @var AnnonceAutomobileRepository $annonceAutomobileRepository */
        $annonceAutomobileRepository = $em->getRepository(AnnonceAutomobile::class);
        $allAutomobiles = $annonceAutomobileRepository->findAll();
        $allGenerique = $annonceGeneriqueRepository->findAll();
        $lastAutomobile = end($allAutomobiles);
        $lastGenerique = end($allGenerique);
        $countAnnonceAutomobile = count($allAutomobiles);
        $countAnnonceGenerique = count($allGenerique);
        $idAutomobile = (string)$lastAutomobile->getId();
        $idGenerique = (string)$lastGenerique->getId();
        $client->request(
            'DELETE',
            '/annonce/' . $idAutomobile
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount($countAnnonceAutomobile - 1, $annonceAutomobileRepository->findAll());
        $this->assertNull($annonceAutomobileRepository->findOneBy(array('id' => $idAutomobile)));

        $client->request(
            'DELETE',
            '/annonce/' . $idGenerique
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount($countAnnonceGenerique - 1, $annonceGeneriqueRepository->findAll());
        $this->assertNull($annonceGeneriqueRepository->findOneBy(array('id' => $idGenerique)));
    }
}
