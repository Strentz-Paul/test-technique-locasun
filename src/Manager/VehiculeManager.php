<?php

namespace App\Manager;

use App\Contracts\Manager\VehiculeManagerInterface;
use App\Entity\Vehicule\VehiculeModele;
use App\Helper\StringHelper;
use App\Helper\Vehicule\ModeleHelper;
use App\Repository\Vehicule\VehiculeModeleRepository;
use Exception;
use PhpParser\Node\Expr\AssignOp\Mod;

class VehiculeManager implements VehiculeManagerInterface
{
    public function __construct(
        private readonly VehiculeModeleRepository $vehiculeModeleRepository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function findVehiculeMatch(string $input): VehiculeModele
    {
        $input = StringHelper::removeAccent(strtolower(trim($input)));
        $maxSimilarity = 0;
        $maxLevenshtein = PHP_INT_MAX;
        $bestMatch = null;
        $allModeles = $this->vehiculeModeleRepository->findAll();

        foreach ($allModeles as $modele) {
            $currentModele = strtolower($modele->getIntitule());
            $keywords = explode(' ', $input);
            similar_text($input, $currentModele, $similarity);
            $levenshteinDistance = levenshtein($input, $currentModele);
            $weightedScore = $similarity - 2 * $levenshteinDistance;
            foreach ($keywords as $keyword) {
                if ($keyword === $currentModele) {
                    return $modele;
                }
                if (stripos($currentModele, $keyword) !== false) {
                    $weightedScore += 30;
                }
            }

            if ($weightedScore > $maxSimilarity && $similarity >= 30) {
                $maxSimilarity = $weightedScore;
                $maxLevenshtein = $levenshteinDistance;
                $bestMatch = $modele;
            } elseif ($weightedScore == $maxSimilarity && $levenshteinDistance < $maxLevenshtein) {
                $maxLevenshtein = $levenshteinDistance;
                $bestMatch = $modele;
            }
        }

        if ($bestMatch === null) {
            throw new Exception('Aucun véhicule trouvé pour le modèle : ' . $input);
        }

        return $bestMatch;
    }
}
