<?php

namespace App\Dto;

class AnnonceAutomobileInputDto extends AbstractAnnonceInputDto
{
    private ?string $modele;

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(?string $modele): void
    {
        $this->modele = $modele;
    }
}
