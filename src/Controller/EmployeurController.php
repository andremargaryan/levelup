<?php
 
namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
 
#[Route('/employeur', name: 'app_employeur_')]
final class EmployeurController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(OffreRepository $offreRepository): Response
    {
        $offres = $offreRepository->findAll();

        return $this->render('employeur/dashboard.html.twig', [
            'offres'       => $offres,
            'candidatures' => [],
            'profils'      => [],
        ]);
    }

    #[Route('/offre/nouvelle', name: 'nouvelle_offre', methods: ['GET', 'POST'])]
    public function nouvelleOffre(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offre);
            $entityManager->flush();
            return $this->redirectToRoute('app_employeur_dashboard');
        }

        return $this->render('employeur/offre_ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/offre/delete/{id}', name: 'delete', methods: ['GET'])]
    public function delete(Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($offre);
        $entityManager->flush();
        return $this->redirectToRoute('app_employeur_dashboard');
    }

    #[Route('/offre/edit/{id}', name: 'offre_edit', methods: ['GET', 'POST'])]
    public function offreEdit(Offre $offre, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_employeur_offre_detail', ['id' => $offre->getId()]);
        }

        return $this->render('employeur/offre_modif.html.twig', [
            'offre' => $offre,
            'form'  => $form,
        ]);
    }

    #[Route('/offre/{id}', name: 'offre_detail')]
    public function offreDetail(Offre $offre): Response
    {
        return $this->render('employeur/offre_detail.html.twig', [
            'offre' => $offre,
        ]);
    }
/*

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
*/
}