<?php

namespace App\Controller;

use App\Contracts\Manager\AnnonceManagerInterface;
use App\Dto\AbstractAnnonceInputDto;
use App\Dto\AnnonceAutomobileInputDto;
use App\Dto\AnnonceGeneriqueInputDto;
use App\Entity\Annonce\Annonce;
use App\Helper\Api\ApiHelper;
use App\Helper\Api\ObjectHydrator;
use Exception;
use HttpMalformedHeadersException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonces', name: 'app_annonce')]
    public function index(
        AnnonceManagerInterface $annonceManager
    ): Response {
        $data = $annonceManager->getAllAnnonces();
        return $this->json($data);
    }

    #[Route('/annonce', name: 'app_annonce_create', methods: "POST")]
    public function create(
        AnnonceManagerInterface $annonceManager,
        Request $request
    ): Response {
        if ($request->getContentTypeFormat() !== ApiHelper::CONTENT_TYPE_FORMAT) {
            throw new Exception("Please use Json for your body request");
        }
        $content = json_decode($request->getContent(), true);
        $dtoClass = new AnnonceGeneriqueInputDto();
        if (array_key_exists('modele', $content)) {
            $dtoClass = new AnnonceAutomobileInputDto();
        }
        /** @var AbstractAnnonceInputDto $input */
        $input = ObjectHydrator::hydrate(
            $content,
            $dtoClass
        );
        try {
            $data = $annonceManager->create($input);
            return $this->json($data);
        } catch (Exception $exception) {
            return $this->json($exception->getMessage());
        }
    }

    #[Route('/annonce/{id}', name: 'app_annonce_get', methods: "GET")]
    public function get(
        AnnonceManagerInterface $annonceManager,
        Request $request
    ): Response {
        $id = $request->attributes->get('id');
        try {
            $data = $annonceManager->get($id);
            return $this->json($data);
        } catch (Exception $exception) {
            return $this->json($exception->getMessage());
        }
    }

    #[Route('/annonce/{id}', name: 'app_annonce_update', methods: "PUT")]
    public function update(
        AnnonceManagerInterface $annonceManager,
        Request $request
    ): Response {
        if ($request->getContentTypeFormat() !== ApiHelper::CONTENT_TYPE_FORMAT) {
            throw new Exception("Please use Json for your body request");
        }
        $content = json_decode($request->getContent(), true);
        $dtoClass = new AnnonceGeneriqueInputDto();
        if (array_key_exists('modele', $content)) {
            $dtoClass = new AnnonceAutomobileInputDto();
        }
        /** @var AbstractAnnonceInputDto $input */
        $input = ObjectHydrator::hydrate(
            $content,
            $dtoClass
        );
        $input->setId($request->attributes->get('id'));
        try {
            $data = $annonceManager->update($input);
            return $this->json($data);
        } catch (Exception $exception) {
            return $this->json($exception->getMessage());
        }
    }

    #[Route('/annonce/{id}', name: 'app_annonce_remove', methods: "DELETE")]
    public function remove(
        AnnonceManagerInterface $annonceManager,
        Request $request
    ): Response {
        $annonceId = $request->attributes->get('id');
        try {
            $annonceManager->remove($annonceId);
            return $this->json('L\'annonce a bien été supprimée.');
        } catch (Exception $exception) {
            return $this->json($exception->getMessage());
        }
    }
}
