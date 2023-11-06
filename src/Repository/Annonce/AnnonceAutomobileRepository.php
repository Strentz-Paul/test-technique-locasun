<?php

namespace App\Repository\Annonce;

use App\Dto\AnnonceAutomobileInputDto;
use App\Entity\Annonce\Annonce;
use App\Entity\Annonce\AnnonceAutomobile;
use App\Entity\Vehicule\VehiculeModele;
use App\Enum\AnnonceCategorieEnum;
use App\Repository\Vehicule\VehiculeModeleRepository;
use App\ViewModel\AbstractAnnonceViewModel;
use App\ViewModel\AnnonceAutomobileViewModel;
use App\ViewModel\AnnonceViewModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

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
    public const ALIAS_ANNONCE_AUTOMOBILE = "annonce_automobile";

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnonceAutomobile::class);
    }

    /**
     * @return Collection<AbstractAnnonceViewModel>
     */
    public function getAllAnnonces(): Collection
    {
        $vm = AnnonceAutomobileViewModel::class;
        $alias = self::ALIAS_ANNONCE_AUTOMOBILE;
        $aliasVehicule = VehiculeModeleRepository::ALIAS_VEHICULE;
        $qb = $this->_em->createQueryBuilder();
        $qb->from(AnnonceAutomobile::class, $alias)
            ->select("NEW $vm(" .
                "$alias.id," .
                "$alias.titre," .
                "$alias.contenu," .
                "$alias.categorie," .
                "$aliasVehicule.intitule," .
                "$aliasVehicule.marque" .
                ")");
        self::addVehiculeContraint($qb, $alias, $aliasVehicule);
        return new ArrayCollection($qb->getQuery()->getResult());
    }

    /**
     * @param string $id
     * @return AnnonceAutomobileViewModel|null
     * @throws NonUniqueResultException
     */
    public function findOneByUuid(string $id): ?AnnonceAutomobileViewModel
    {
        $vm = AnnonceAutomobileViewModel::class;
        $alias = self::ALIAS_ANNONCE_AUTOMOBILE;
        $aliasVehicule = VehiculeModeleRepository::ALIAS_VEHICULE;
        $qb = $this->_em->createQueryBuilder();
        $qb->from(AnnonceAutomobile::class, $alias)
            ->select("NEW $vm(" .
                "$alias.id," .
                "$alias.titre," .
                "$alias.contenu," .
                "$alias.categorie," .
                "$aliasVehicule.intitule," .
                "$aliasVehicule.marque" .
                ")");
        self::addVehiculeContraint($qb, $alias, $aliasVehicule);
        self::addIdWhere($qb, $id, $alias);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param AnnonceAutomobileInputDto $dto
     * @param VehiculeModele $vehiculeModele
     * @return AnnonceAutomobileViewModel
     */
    public function create(AnnonceAutomobileInputDto $dto, VehiculeModele $vehiculeModele): AnnonceAutomobileViewModel
    {
        $categorie = AnnonceCategorieEnum::from($dto->getCategorie());
        $annonce = (new AnnonceAutomobile())
            ->setTitre($dto->getTitre())
            ->setContenu($dto->getContenu())
            ->setCategorie($categorie)
            ->setVehicule($vehiculeModele);
        $this->_em->persist($annonce);
        $this->_em->flush();
        return new AnnonceAutomobileViewModel(
            $annonce->getId(),
            $annonce->getTitre(),
            $annonce->getContenu(),
            $annonce->getCategorie(),
            $vehiculeModele->getIntitule(),
            $vehiculeModele->getMarque()
        );
    }

    /**
     * @param AnnonceAutomobileInputDto $dto
     * @param VehiculeModele $vehiculeModele
     * @return AnnonceAutomobileViewModel
     * @throws Exception
     */
    public function update(AnnonceAutomobileInputDto $dto, VehiculeModele $vehiculeModele): AnnonceAutomobileViewModel
    {
        $categorie = AnnonceCategorieEnum::from($dto->getCategorie());
        $annonce = self::findOneBy(array('id' => $dto->getId()));
        if ($annonce === null) {
            throw new Exception('Pour qu\'elle soit modifiée, il faut que l\'annonce existe.');
        }
        $annonce
            ->setTitre($dto->getTitre())
            ->setContenu($dto->getContenu())
            ->setCategorie($categorie)
            ->setVehicule($vehiculeModele);
        $this->_em->persist($annonce);
        $this->_em->flush();
        return new AnnonceAutomobileViewModel(
            $annonce->getId(),
            $annonce->getTitre(),
            $annonce->getContenu(),
            $annonce->getCategorie(),
            $vehiculeModele->getIntitule(),
            $vehiculeModele->getMarque()
        );
    }

    /**
     * @param AnnonceAutomobile $annonce
     * @return void
     */
    public function remove(AnnonceAutomobile $annonce): void
    {
        $this->_em->remove($annonce);
        $this->_em->flush();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $alias
     * @param string $aliasVehicule
     * @param int $joinType
     * @return QueryBuilder
     */
    public static function addVehiculeContraint(
        QueryBuilder $queryBuilder,
        string $alias = self::ALIAS_ANNONCE_AUTOMOBILE,
        string $aliasVehicule = VehiculeModeleRepository::ALIAS_VEHICULE,
        int $joinType = Join::JOIN_TYPE_LEFT
    ): QueryBuilder {
        $relation = "$alias.vehicule";
        $joinType = $joinType === Join::JOIN_TYPE_LEFT ? 'leftjoin' : 'innerjoin';
        return $queryBuilder->$joinType($relation, $aliasVehicule);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $id
     * @param string $alias
     * @return QueryBuilder
     */
    public static function addIdWhere(
        QueryBuilder $queryBuilder,
        string $id,
        string $alias = self::ALIAS_ANNONCE_AUTOMOBILE,
    ): QueryBuilder {
        return $queryBuilder
            ->andWhere("$alias.id = :id")
            ->setParameter("id", $id);
    }
}
