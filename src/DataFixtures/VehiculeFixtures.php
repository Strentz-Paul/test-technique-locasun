<?php

namespace App\DataFixtures;

use App\Entity\Vehicule\VehiculeModele;
use App\Helper\Vehicule\MarqueHelper;
use App\Helper\Vehicule\ModeleHelper;
use Doctrine\Persistence\ObjectManager;
use PhpParser\Node\Expr\AssignOp\Mod;

class VehiculeFixtures extends AbstractFixtures
{
    public const REFERENCE_VEHICULE = 'vehicule_';

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $allVehicules = array_merge(ModeleHelper::MODELE_AUDI, ModeleHelper::MODELE_BMW, ModeleHelper::MODELE_CITROEN);
        $countVehicule = count($allVehicules);
        for ($i = 0; $i < $countVehicule; $i++) {
            $vehicule = new VehiculeModele($allVehicules[$i]);
            $manager->persist($vehicule);
            $this->addReference(self::REFERENCE_VEHICULE . $i, $vehicule);
        }
        $manager->flush();
    }
}
