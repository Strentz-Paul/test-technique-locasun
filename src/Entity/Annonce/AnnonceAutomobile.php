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

    public function getVehicule(): ?VehiculeModele
    {
        return $this->vehicule;
    }

    public function setVehicule(?VehiculeModele $vehicule): static
    {
        $this->vehicule = $vehicule;
        return $this;
    }
}
