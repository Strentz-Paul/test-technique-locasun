<?php

namespace App\Manager;

use App\Contracts\Manager\AnnonceManagerInterface;
use App\Contracts\Manager\VehiculeManagerInterface;
use App\Dto\AbstractAnnonceInputDto;
use App\Dto\AnnonceAutomobileInputDto;
use App\Dto\AnnonceGeneriqueInputDto;
use App\Entity\Annonce\AnnonceAutomobile;
use App\Entity\Annonce\AnnonceGenerique;
use App\Repository\Annonce\AnnonceAutomobileRepository;
use App\Repository\Annonce\AnnonceGeneriqueRepository;
use App\ViewModel\AbstractAnnonceViewModel;
use App\ViewModel\AnnonceAutomobileViewModel;
use App\ViewModel\AnnonceViewModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\NonUniqueResultException;

class AnnonceManager implements AnnonceManagerInterface
{
    public function __construct(
        private readonly AnnonceGeneriqueRepository $annonceGeneriqueRepository,
        private readonly AnnonceAutomobileRepository $annonceAutomobileRepository,
        private readonly VehiculeManagerInterface $vehiculeManager
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getAllAnnonces(): Collection
    {
        $annoncesGenerique = $this->annonceGeneriqueRepository->getAllAnnonces()->toArray();
        $annoncesAutomobile = $this->annonceAutomobileRepository->getAllAnnonces()->toArray();
        return new ArrayCollection(array_merge($annoncesGenerique, $annoncesAutomobile));
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $id): AbstractAnnonceViewModel
    {
        /** @var AnnonceAutomobileViewModel|null $annonce */
        $annonce = $this->annonceAutomobileRepository->findOneByUuid($id);
        if ($annonce !== null) {
            return $annonce;
        }
        /** @var AnnonceViewModel|null $annonce */
        $annonce = $this->annonceGeneriqueRepository->findOneByUuid($id);
        if ($annonce === null) {
            throw new \Exception('Il n\'y a pas d\'annonce correspondante à cet identifiant: ' . $id);
        }
        return $annonce;
    }

    /**
     * {@inheritDoc}
     */
    public function create(AbstractAnnonceInputDto $dto): AbstractAnnonceViewModel
    {
        if ($dto instanceof AnnonceGeneriqueInputDto) {
            return $this->annonceGeneriqueRepository->create($dto);
        }
        /** @var AnnonceAutomobileInputDto $dto */
        $vehicule = $this->vehiculeManager->findVehiculeMatch($dto->getModele());
        return $this->annonceAutomobileRepository->create($dto, $vehicule);
    }

    /**
     * {@inheritDoc}
     */
    public function update(AbstractAnnonceInputDto $dto): AbstractAnnonceViewModel
    {
        if ($dto instanceof AnnonceGeneriqueInputDto) {
            return $this->annonceGeneriqueRepository->update($dto);
        }
        /** @var AnnonceAutomobileInputDto $dto */
        $vehicule = $this->vehiculeManager->findVehiculeMatch($dto->getModele());
        return $this->annonceAutomobileRepository->update($dto, $vehicule);
    }

    /**
     * {@inheritDoc}
     */
    public function remove(string $annonceId): void
    {
        /** @var AnnonceAutomobile|null $annonce */
        $annonce = $this->annonceAutomobileRepository->findOneBy(array('id' => $annonceId));
        if ($annonce !== null) {
            $this->annonceAutomobileRepository->remove($annonce);
            return;
        }
        /** @var AnnonceGenerique|null $annonce */
        $annonce = $this->annonceGeneriqueRepository->findOneBy(array('id' => $annonceId));
        if ($annonce === null) {
            throw new \Exception('Il n\'y a pas d\'annonce correspondante à cet identifiant: ' . $annonceId);
        }
        $this->annonceGeneriqueRepository->remove($annonce);
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(): array
    {
        return array_merge($this->annonceAutomobileRepository->findAll(), $this->annonceGeneriqueRepository->findAll());
    }

    /**
     * {@inheritDoc}
     */
    public function findAllForJson(): array
    {
        $annoncesArray = [];
        $all = $this->findAll();
        foreach ($all as $annonce) {
            $annoncesArray[] = $annonce->toArray();
        }
        return $annoncesArray;
    }
}
