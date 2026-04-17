<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/jeux/{jeu}/gagner/{points}', name: 'jeu_gagner', methods: ['POST'])]
    public function gagner(
        string $jeu,
        int $points,
        Request $request,
        UserRepository $userRepository
    ): Response {
        $userName = $request->getSession()->get('user');

        if (!$userName) {
            return $this->json(['error' => 'Non connecté'], 401);
        }

        $user = $userRepository->findOneBy(['prenom' => $userName]);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur introuvable'], 404);
        }

        $userRepository->addPoints($user, $points);

        return $this->json([
            'success' => true,
            'jeu' => $jeu,
            'points' => $user->getPoint()
        ]);
    }

    #[Route('/jeux/flappystage/gagner', name: 'jeu_flappystage_gagner')]
    public function gagnerFlappystage(Request $request, UserRepository $userRepository): Response
    {
        $userName = $request->getSession()->get('user');

        if (!$userName) {
            return $this->json(['error' => 'Non connecté'], 401);
        }

        $user = $userRepository->findOneBy(['prenom' => $userName]);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur introuvable'], 404);
        }

        $userRepository->addPoints($user, 10);

        return $this->json([
            'success' => true,
            'points' => $user->getPoint()
        ]);
    }

    #[Route('/jeux/sudoku/gagner', name: 'jeu_sudoku_gagner')]
    public function gagnerSudoku(Request $request, UserRepository $userRepository): Response
    {
        $userName = $request->getSession()->get('user');

        if (!$userName) {
            return $this->json(['error' => 'Non connecté'], 401);
        }

        $user = $userRepository->findOneBy(['prenom' => $userName]);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur introuvable'], 404);
        }

        $userRepository->addPoints($user, 10);

        return $this->json([
            'success' => true,
            'points' => $user->getPoint()
        ]);
    }
}