<?php

namespace App\Repository\Annonce;

use App\Entity\Annonce\AnnonceGenerique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnnonceGenerique>
 *
 * @method AnnonceGenerique|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnnonceGenerique|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnnonceGenerique[]    findAll()
 * @method AnnonceGenerique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceGeneriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnonceGenerique::class);
    }
}
