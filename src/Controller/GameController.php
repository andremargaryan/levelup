<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
 
class GameController extends AbstractController
{
    #[Route('/jeux/morpion', name: 'app_morpion')]
    public function morpion(): Response
    {
        return $this->render('jeux/morpion.html.twig');
    }

    #[Route('/jeux/flappystage', name: 'app_flappystage')]
    public function flappystage(): Response
    {
        return $this->render('jeux/flappystage.html.twig');
    }
}