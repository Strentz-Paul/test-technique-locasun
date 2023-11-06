<?php

namespace App\Repository\Vehicule;

use App\Entity\Vehicule\VehiculeModele;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehiculeModele>
 *
 * @method VehiculeModele|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehiculeModele|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehiculeModele[]    findAll()
 * @method VehiculeModele[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculeModeleRepository extends ServiceEntityRepository
{
    public const ALIAS_VEHICULE = "vehicule";

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehiculeModele::class);
    }

    /**
     * @return int
     */
    public function getCountAllVehicule(): int
    {
        return count($this->findAll());
    }
}
