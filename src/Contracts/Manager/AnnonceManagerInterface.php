<?php

namespace App\Contracts\Manager;

use App\Dto\AbstractAnnonceInputDto;
use App\Entity\Annonce\Annonce;
use App\Entity\Annonce\AnnonceAutomobile;
use App\Entity\Annonce\AnnonceGenerique;
use App\ViewModel\AbstractAnnonceViewModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\NonUniqueResultException;
use Exception;

interface AnnonceManagerInterface
{
    /**
     * @return Collection<AbstractAnnonceViewModel>
     */
    public function getAllAnnonces(): Collection;

    /**
     * @param string $id
     * @return AbstractAnnonceViewModel
     * @throws NonUniqueResultException
     */
    public function get(string $id): AbstractAnnonceViewModel;

    /**
     * @param AbstractAnnonceInputDto $dto
     * @return AbstractAnnonceViewModel
     */
    public function create(AbstractAnnonceInputDto $dto): AbstractAnnonceViewModel;

    /**
     * @param AbstractAnnonceInputDto $dto
     * @return AbstractAnnonceViewModel
     * @throws Exception
     */
    public function update(AbstractAnnonceInputDto $dto): AbstractAnnonceViewModel;

    /**
     * @param string $annonceId
     * @throws Exception
     */
    public function remove(string $annonceId): void;

    /**
     * @return array<AnnonceGenerique|AnnonceAutomobile>
     */
    public function findAll(): array;

    /**
     * @return array<mixed>
     */
    public function findAllForJson(): array;
}
