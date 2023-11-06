<?php

namespace App\Repository\Annonce;

use App\Dto\AnnonceGeneriqueInputDto;
use App\Entity\Annonce\AnnonceGenerique;
use App\Enum\AnnonceCategorieEnum;
use App\ViewModel\AnnonceViewModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

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
    public const ALIAS_ANNONCE_GENERIQUE = "annonce_generique";

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnonceGenerique::class);
    }

    /**
     * @return Collection<AnnonceViewModel>
     */
    public function getAllAnnonces(): Collection
    {
        $vm = AnnonceViewModel::class;
        $alias = self::ALIAS_ANNONCE_GENERIQUE;
        $qb = $this->_em->createQueryBuilder();
        $qb->from(AnnonceGenerique::class, $alias)
            ->select("NEW $vm(" .
                "$alias.id," .
                "$alias.titre," .
                "$alias.contenu," .
                "$alias.categorie" .
                ")");
        return new ArrayCollection($qb->getQuery()->getResult());
    }

    /**
     * @param string $id
     * @return AnnonceViewModel|null
     * @throws NonUniqueResultException
     */
    public function findOneByUuid(string $id): ?AnnonceViewModel
    {
        $vm = AnnonceViewModel::class;
        $alias = self::ALIAS_ANNONCE_GENERIQUE;
        $qb = $this->_em->createQueryBuilder();
        $qb->from(AnnonceGenerique::class, $alias)
            ->select("NEW $vm(" .
                "$alias.id," .
                "$alias.titre," .
                "$alias.contenu," .
                "$alias.categorie" .
                ")");
        self::addIdWhere($qb, $id, $alias);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param AnnonceGeneriqueInputDto $dto
     * @return AnnonceViewModel
     */
    public function create(AnnonceGeneriqueInputDto $dto): AnnonceViewModel
    {
        $categorie = AnnonceCategorieEnum::from($dto->getCategorie());
        $annonce = (new AnnonceGenerique())
            ->setTitre($dto->getTitre())
            ->setContenu($dto->getContenu())
            ->setCategorie($categorie);
        $this->_em->persist($annonce);
        $this->_em->flush();
        return new AnnonceViewModel(
            $annonce->getId(),
            $annonce->getTitre(),
            $annonce->getContenu(),
            $annonce->getCategorie()
        );
    }

    /**
     * @param AnnonceGeneriqueInputDto $dto
     * @return AnnonceViewModel
     * @throws Exception
     */
    public function update(AnnonceGeneriqueInputDto $dto): AnnonceViewModel
    {
        $categorie = AnnonceCategorieEnum::from($dto->getCategorie());
        $annonce = self::findOneBy(array('id' => $dto->getId()));
        if ($annonce === null) {
            throw new Exception('Pour qu\'elle soit modifiée, il faut que l\'annonce existe.');
        }
        $annonce
            ->setTitre($dto->getTitre())
            ->setContenu($dto->getContenu())
            ->setCategorie($categorie);
        $this->_em->persist($annonce);
        $this->_em->flush();
        return new AnnonceViewModel(
            $annonce->getId(),
            $annonce->getTitre(),
            $annonce->getContenu(),
            $annonce->getCategorie()
        );
    }

    /**
     * @param AnnonceGenerique $annonce
     * @return void
     */
    public function remove(AnnonceGenerique $annonce): void
    {
        $this->_em->remove($annonce);
        $this->_em->flush();
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
        string $alias = self::ALIAS_ANNONCE_GENERIQUE,
    ): QueryBuilder {
        return $queryBuilder
            ->andWhere("$alias.id = :id")
            ->setParameter("id", $id);
    }
}
