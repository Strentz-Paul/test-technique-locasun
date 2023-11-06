<?php

namespace App\Contracts\Manager;

use App\Entity\Vehicule\VehiculeModele;

interface VehiculeManagerInterface
{
    /**
     * @param string $input
     * @return VehiculeModele
     */
    public function findVehiculeMatch(string $input): VehiculeModele;
}
