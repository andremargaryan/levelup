<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/swip', name: 'app_swip')]
    public function homeSwip(): Response
    {
        return $this->render('swip.html.twig');
    }

}
