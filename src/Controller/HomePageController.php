<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class HomePageController extends AbstractController
{
    #[Route('/home/page', name: 'app_home_page')]
    public function index(): Response
    {
        return $this->render('home/home_page1.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

    #[Route('/home/swip', name: 'app_home_swip')]
    public function homeSwip(OffreRepository $offreRepository): Response
    {
        $offre = $offreRepository->findOneBy([], ['id' => 'ASC']);

        return $this->render('home/swip.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/user/profile', name: 'app_user_profile')]
    public function profile(): Response
    {
    return $this->render('comptes/profile.html.twig');
    }

    #[Route('/comptes/inscription', name: 'app_comptes_inscription')]
    public function register(Request $request, UserRepository $userRepository): Response
    {

        $user = new User();


        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

           
            $userRepository->save($user);

            return $this->redirectToRoute('app_home_page');
        }

        return $this->render('comptes/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        #[Route('/comptes/connexion', name: 'app_comptes_connexion')]
    public function connexion(Request $request, UserRepository $userRepository): Response
    {
        if ($request->isMethod('POST')) {
            $mail = $request->request->get('mail');
            $mdp  = $request->request->get('mot_de_passe');

            $utilisateur = $userRepository->findOneBy(['mail' => $mail]);

            if ($utilisateur && $utilisateur->getMotDePasse() === $mdp) {
                $request->getSession()->set('user', $utilisateur->getPrenom());
                return $this->redirectToRoute('app_home_page');
            }

            return $this->render('comptes/connexion.html.twig', [
                'erreur' => 'Email ou mot de passe incorrect.'
            ]);
        }

        return $this->render('comptes/connexion.html.twig');
    }

    #[Route('/comptes/deconnexion', name: 'app_comptes_deconnexion')]
    public function deconnexion(Request $request): Response
    {
        $request->getSession()->remove('user');
        return $this->render('home/home_page1.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

}
