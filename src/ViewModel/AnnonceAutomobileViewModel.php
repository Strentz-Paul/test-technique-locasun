<?php

namespace App\ViewModel;

use App\Enum\AnnonceCategorieEnum;
use App\Enum\MarqueVehiculeEnum;

class AnnonceAutomobileViewModel extends AbstractAnnonceViewModel
{
    public function __construct(
        string $uuid,
        string $titre,
        string $contenu,
        AnnonceCategorieEnum $categorie,
        private readonly string $modeleVehicule,
        private readonly MarqueVehiculeEnum $marqueVehicule
    ) {
        parent::__construct($uuid, $titre, $contenu, $categorie);
    }

    public function getModeleVehicule(): ?string
    {
        return $this->modeleVehicule;
    }

    public function getMarqueVehicule(): ?MarqueVehiculeEnum
    {
        return $this->marqueVehicule;
    }
}
