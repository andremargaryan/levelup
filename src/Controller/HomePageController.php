<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Offre;
use App\Entity\Swip;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function homeSwip(OffreRepository $offreRepository, Request $request, UserRepository $userRepository): Response
    {
        $userId = $request->getSession()->get('user_id');

        if (!$userId) {
            return $this->redirectToRoute('app_comptes_connexion');
        }

        $user = $userRepository->find($userId);

        if (!$user) {
            return $this->redirectToRoute('app_comptes_connexion');
        }

        $offre = $offreRepository->findPremiereOffreNonSwipee($user);

        return $this->render('home/swip.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/offre/swipe/{id}/{action}', name: 'swip')]
    public function swip(
        Offre $offre,
        string $action,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        Request $request
    ): JsonResponse {
        $userId = $request->getSession()->get('user_id');
        $user = $userRepository->find($userId);

        if (!$user) {
            return new JsonResponse(['error' => 'Non connecté'], 401);
        }

        $swipe = new Swip();
        $swipe->setUser($user);
        $swipe->setOffre($offre);
        $swipe->setLiked($action === 'like');
        $swipe->setSwipedAt(new \DateTime());

        $em->persist($swipe);
        $em->flush();

        return new JsonResponse(['status' => 'ok']);
    }

    #[Route('/user/profile', name: 'app_user_profile')]
    public function profile(): Response
    {
        return $this->render('comptes/profile.html.twig');
    }

    #[Route('/comptes/inscription', name: 'app_comptes_inscription')]
    public function register(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {

        $user = new User();


        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mdpEnClair=$user->getPassword();

            $mdpHash = $passwordHasher->hashPassword($user,$mdpEnClair);

            $user->setPassword($mdpHash);

            $userRepository->save($user);

            return $this->redirectToRoute('app_home_page');
        }

        return $this->render('comptes/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        #[Route('/comptes/connexion', name: 'app_comptes_connexion')]
    public function connexion(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher): Response
    {
        if ($request->isMethod('POST')) {
            $mail = $request->request->get('mail');
            $mdp  = $request->request->get('mot_de_passe');

            $utilisateur = $userRepository->findOneBy(['mail' => $mail]);

            if ($utilisateur && $hasher->isPasswordValid($utilisateur, $mdp)) {
                $request->getSession()->set('user', $utilisateur->getPrenom());
                $request->getSession()->set('estEmployeur', $utilisateur->isEstEmployeur());
                $request->getSession()->set('user_id', $utilisateur->getId());
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
