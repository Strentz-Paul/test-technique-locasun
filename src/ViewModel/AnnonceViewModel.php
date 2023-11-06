<?php

namespace App\ViewModel;

use App\Enum\AnnonceCategorieEnum;

class AnnonceViewModel extends AbstractAnnonceViewModel
{
    public function __construct(
        string $uuid,
        string $titre,
        string $contenu,
        AnnonceCategorieEnum $categorie
    ) {
        parent::__construct($uuid, $titre, $contenu, $categorie);
    }
}
