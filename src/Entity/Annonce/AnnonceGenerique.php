<?php

namespace App\Entity\Annonce;

use App\Repository\Annonce\AnnonceGeneriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceGeneriqueRepository::class)]
class AnnonceGenerique extends Annonce
{
    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'titre' => $this->getTitre(),
            'contenu' => $this->getContenu(),
            'categorie' => $this->getCategorie()
        ];
    }
}
