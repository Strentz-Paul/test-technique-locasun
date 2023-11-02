<?php

namespace App\Repository\Annonce;

use App\Entity\Annonce\AnnonceAutomobile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnnonceAutomobile>
 *
 * @method AnnonceAutomobile|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnnonceAutomobile|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnnonceAutomobile[]    findAll()
 * @method AnnonceAutomobile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceAutomobileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnonceAutomobile::class);
    }
}
