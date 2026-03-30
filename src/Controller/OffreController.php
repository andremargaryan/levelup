<?php

namespace App\Controller;


use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class OffreController extends AbstractController
{
    #[Route('/offres', name: 'app_offres')]
    public function index(OffreRepository $repo): Response
    {
        $offre = $repo->findOneBy([], ['id' => 'ASC']);

        return $this->render('offres/swip.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/offres/next/{id}', name: 'app_offres_next')]
    public function next(int $id, OffreRepository $repo): JsonResponse
    {
        $offre = $repo->findNextOffre($id);

        if (!$offre) {
            return $this->json(['done' => true]);
        }

        return $this->json([
            'id'          => $offre->getId(),
            'titre'       => $offre->getTitre(),
            'description' => $offre->getDescription(),
            'entreprise'  => $offre->getEntreprise(),
            'tag'         => $offre->getTag(),
        ]);
    }

}