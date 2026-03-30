<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
 
#[Route('/employeur', name: 'app_employeur_')]
final class EmployeurController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        
        $offres = [];
        $candidatures = [];
        $profils = [];

        return $this->render('employeur/dashboard.html.twig', [
            'offres'       => $offres,
            'candidatures' => $candidatures,
            'profils'      => $profils,
        ]);
    }
 
    #[Route('/offre/nouvelle', name: 'nouvelle_offre')]
    public function nouvelleOffre(): Response
    {
       
        return $this->render('employeur/nouvelle_offre.html.twig');
    }
 
    #[Route('/candidature/{id}', name: 'candidature_detail')]
    public function candidatureDetail(int $id): Response
    {
       
        return $this->render('employeur/candidature_detail.html.twig', [
            'candidature_id' => $id,
        ]);
    }
}