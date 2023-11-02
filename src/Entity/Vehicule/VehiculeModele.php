<?php

namespace App\Entity\Vehicule;

use App\Entity\Annonce\AnnonceAutomobile;
use App\Entity\BaseEntity;
use App\Enum\MarqueVehiculeEnum;
use App\Helper\Vehicule\MarqueHelper;
use App\Repository\Vehicule\VehiculeModeleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity(repositoryClass: VehiculeModeleRepository::class)]
class VehiculeModele extends BaseEntity
{
    #[ORM\Column(length: 255, nullable: false)]
    private string $intitule;

    #[ORM\Column(type: Types::STRING, nullable: false, enumType: MarqueVehiculeEnum::class)]
    private MarqueVehiculeEnum $marque;

    #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: AnnonceAutomobile::class, orphanRemoval: true)]
    private Collection $annonceAutomobiles;

    public function __construct(string $intitule)
    {
        $this->intitule = $intitule;
        $this->marque = MarqueHelper::defineMarqueByModele($this->intitule);
        $this->annonceAutomobiles = new ArrayCollection();
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @throws Exception
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    private function setMarque(): void
    {
        $this->marque = MarqueHelper::defineMarqueByModele($this->intitule);
    }

    public function getMarque(): MarqueVehiculeEnum
    {
        return $this->marque;
    }

    /**
     * @return Collection<AnnonceAutomobile>
     */
    public function getAnnonceAutomobiles(): Collection
    {
        return $this->annonceAutomobiles;
    }

    public function addAnnonceAutomobile(AnnonceAutomobile $annonceAutomobile): static
    {
        if (!$this->annonceAutomobiles->contains($annonceAutomobile)) {
            $this->annonceAutomobiles->add($annonceAutomobile);
            $annonceAutomobile->setVehicule($this);
        }

        return $this;
    }

    public function removeAnnonceAutomobile(AnnonceAutomobile $annonceAutomobile): static
    {
        if ($this->annonceAutomobiles->removeElement($annonceAutomobile)) {
            // set the owning side to null (unless already changed)
            if ($annonceAutomobile->getVehicule() === $this) {
                $annonceAutomobile->setVehicule(null);
            }
        }

        return $this;
    }
}
