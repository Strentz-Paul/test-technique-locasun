<?php

namespace App\Controller;

use App\Contracts\Manager\AnnonceManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(
        AnnonceManagerInterface $annonceManager
    ): Response {
        return $this->render('default/index.html.twig', [
            'annonces' => $annonceManager->findAll(),
            'annonces_json' => $annonceManager->findAllForJson()
        ]);
    }
}
