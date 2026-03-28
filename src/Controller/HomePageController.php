<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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
    public function homeSwip(): Response
    {
        return $this->render('home/swip.html.twig');
    }

    #[Route('/comptes/connection', name: 'app_comptes_connection')]
    public function register(Request $request, UserRepository $userRepository): Response
    {

        $user = new User();


        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

           
            $userRepository->save($user);

            return $this->redirectToRoute('app_home_page');
        }

        return $this->render('comptes/connection.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
