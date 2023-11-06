<?php

namespace App\ViewModel;

use App\Enum\AnnonceCategorieEnum;
use App\Helper\Api\ApiHelper;

abstract class AbstractAnnonceViewModel
{
    private string $uri;

    public function __construct(
        private readonly string $uuid,
        private readonly string $titre,
        private readonly string $contenu,
        private readonly AnnonceCategorieEnum $categorie
    ) {
        $this->uri = ApiHelper::createUriFromResource(ApiHelper::ANNONCE_BASE_URL, $this->uuid);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function getCategorie(): AnnonceCategorieEnum
    {
        return $this->categorie;
    }
}
