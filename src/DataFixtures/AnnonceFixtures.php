<?php

namespace App\DataFixtures;

use App\Entity\Annonce\AnnonceAutomobile;
use App\Entity\Annonce\AnnonceGenerique;
use App\Entity\Vehicule\VehiculeModele;
use App\Enum\AnnonceCategorieEnum;
use App\Repository\Vehicule\VehiculeModeleRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnonceFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public const NB_ANNONCE_EMPLOI = 15;
    public const NB_ANNONCE_IMMOBILIER = 14;
    public const NB_ANNONCE_AUTOMOBILE = 120;

    public function __construct(
        private readonly VehiculeModeleRepository $vehiculeModeleRepository
    ) {
        parent::__construct();
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->annonceGeneriqueGeneration($manager, self::NB_ANNONCE_EMPLOI, AnnonceCategorieEnum::EMPLOI);
        $this->annonceGeneriqueGeneration($manager, self::NB_ANNONCE_IMMOBILIER, AnnonceCategorieEnum::IMMOBILIER);
        $this->annonceAutomobileGeneration($manager);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            VehiculeFixtures::class
        ];
    }

    /**
     * @param ObjectManager $manager
     * @param int $nbAnnonce
     * @param AnnonceCategorieEnum $categorie
     * @return void
     */
    private function annonceGeneriqueGeneration(
        ObjectManager $manager,
        int $nbAnnonce,
        AnnonceCategorieEnum $categorie
    ): void {
        for ($i = 0; $i < $nbAnnonce; $i++) {
            $annonce = (new AnnonceGenerique())
                ->setTitre($this->faker->text(100))
                ->setContenu($this->faker->realText)
                ->setCategorie($categorie);
            $manager->persist($annonce);
        }
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    private function annonceAutomobileGeneration(
        ObjectManager $manager
    ): void {
        $countAllVehicule = $this->vehiculeModeleRepository->getCountAllVehicule();
        for ($i = 0; $i < self::NB_ANNONCE_AUTOMOBILE; $i++) {
            $vehiculeIndex = rand(0, $countAllVehicule - 1);
            /** @var VehiculeModele $vehicule */
            $vehicule = $this->getReference(VehiculeFixtures::REFERENCE_VEHICULE . $vehiculeIndex);
            $annonce = (new AnnonceAutomobile())
                ->setTitre('Automobile ' . $this->faker->text(100))
                ->setContenu($this->faker->text)
                ->setVehicule($vehicule);
            $manager->persist($annonce);
        }
    }
}
