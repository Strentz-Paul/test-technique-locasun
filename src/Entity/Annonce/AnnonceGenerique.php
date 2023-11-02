<?php

namespace App\Entity\Annonce;

use App\Repository\Annonce\AnnonceGeneriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceGeneriqueRepository::class)]
class AnnonceGenerique extends Annonce
{
}
