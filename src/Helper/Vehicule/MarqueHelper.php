<?php

namespace App\Helper\Vehicule;

use App\Enum\MarqueVehiculeEnum;
use Exception;

class MarqueHelper
{
    /**
     * @param string $modele
     * @return MarqueVehiculeEnum
     * @throws Exception
     */
    public static function defineMarqueByModele(string $modele): MarqueVehiculeEnum
    {
        return match (true) {
            in_array($modele, ModeleHelper::MODELE_AUDI) => MarqueVehiculeEnum::AUDI,
            in_array($modele, ModeleHelper::MODELE_BMW) => MarqueVehiculeEnum::BMW,
            in_array($modele, ModeleHelper::MODELE_CITROEN) => MarqueVehiculeEnum::CITROEN,
            default => throw new Exception('Ce modèle de véhicule n\'est pas géré par l\'application')
        };
    }
}
