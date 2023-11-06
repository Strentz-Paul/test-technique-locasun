<?php

namespace App\Tests\Repository;

use App\Entity\Annonce\AnnonceAutomobile;
use App\Entity\Annonce\AnnonceGenerique;
use App\Repository\Annonce\AnnonceAutomobileRepository;
use App\Repository\Annonce\AnnonceGeneriqueRepository;
use App\ViewModel\AnnonceAutomobileViewModel;
use App\ViewModel\AnnonceViewModel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnnonceRepositoryTest extends KernelTestCase
{
    private AnnonceAutomobileRepository $annonceAutomobileRepository;
    private AnnonceGeneriqueRepository $annonceGeneriqueRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->annonceAutomobileRepository = $this->entityManager->getRepository(AnnonceAutomobile::class);
        $this->annonceGeneriqueRepository = $this->entityManager->getRepository(AnnonceGenerique::class);
    }

    public function testGetAllAnnoncesAutomobile(): void
    {
        $countAllAnnonceAutomobile = count($this->annonceAutomobileRepository->findAll());
        $result = $this->annonceAutomobileRepository->getAllAnnonces();
        self::assertCount($countAllAnnonceAutomobile, $result);
        self::assertInstanceOf(AnnonceAutomobileViewModel::class, $result->first());
    }

    public function testGetAllAnnoncesGenerique(): void
    {
        $countAllAnnonceAutomobile = count($this->annonceGeneriqueRepository->findAll());
        $result = $this->annonceGeneriqueRepository->getAllAnnonces();
        self::assertCount($countAllAnnonceAutomobile, $result);
        self::assertInstanceOf(AnnonceViewModel::class, $result->first());
    }
}
