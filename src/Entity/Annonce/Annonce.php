<?php

namespace App\Entity\Annonce;

use App\Entity\BaseEntity;
use App\Enum\AnnonceCategorieEnum;
use App\Repository\Annonce\AnnonceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'type', type: 'string')]
#[DiscriminatorMap([
    'Generique' => AnnonceGenerique::class,
    'Automobile' => AnnonceAutomobile::class
])]
abstract class Annonce extends BaseEntity
{
    #[ORM\Column(length: 255, nullable: false)]
    protected string $titre;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    protected string $contenu;

    #[ORM\Column(type: Types::STRING, nullable: false, enumType: AnnonceCategorieEnum::class)]
    protected AnnonceCategorieEnum $categorie;

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCategorie(): AnnonceCategorieEnum
    {
        return $this->categorie;
    }

    public function setCategorie(AnnonceCategorieEnum $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
