test
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

    #[Route('/home/swip', name: 'app_home_swip')]
    public function homeSwip(): Response
    {
        return $this->render('home/swip.html.twig');
    }

     #[Route('/home/connexion', name: 'app_home_connexion')]
    public function homeConnection(): Response
    {
        return $this->render('home/connexion.html.twig');
    }

}
