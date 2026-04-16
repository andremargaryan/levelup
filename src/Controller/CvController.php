<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CvController extends AbstractController
{
    #[Route('/cv/creer', name: 'app_cv_creer')]
    public function creer(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', false);
            $options->set('isRemoteEnabled', false);

            $dompdf = new Dompdf($options);

            $html = $this->renderView('cv/template_cv.html.twig', [
                'data' => $data,
            ]);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return new Response(
                $dompdf->output(),
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="mon-cv.pdf"',
                ]
            );
        }

        return $this->render('cv/creer.html.twig');
    }
}