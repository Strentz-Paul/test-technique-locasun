<?php

namespace App\Entity\Annonce;

use App\Entity\Vehicule\VehiculeModele;
use App\Enum\AnnonceCategorieEnum;
use App\Repository\Annonce\AnnonceAutomobileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceAutomobileRepository::class)]
class AnnonceAutomobile extends Annonce
{
    #[ORM\ManyToOne(inversedBy: 'annonceAutomobiles')]
    #[ORM\JoinColumn(nullable: true)]
    private ?VehiculeModele $vehicule;

    public function __construct()
    {
        $this->categorie = AnnonceCategorieEnum::AUTOMOBILE;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'titre' => $this->getTitre(),
            'contenu' => $this->getContenu(),
            'modele' => $this->getVehicule()->getIntitule(),
            'marque' => $this->getVehicule()->getMarque(),
            'categorie' => $this->getCategorie()
        ];
    }

    public function getVehicule(): ?VehiculeModele
    {
        return $this->vehicule;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setCategorie(AnnonceCategorieEnum $categorie): static
    {
        $this->categorie = AnnonceCategorieEnum::AUTOMOBILE;
        return $this;
    }

    public function setVehicule(?VehiculeModele $vehicule): static
    {
        $this->vehicule = $vehicule;
        return $this;
    }
}
