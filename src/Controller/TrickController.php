<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick', name: 'app_trick_')]
class TrickController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('trick/index.html.twig');
    }

    #[Route('/{slug}', name: 'app_detailTrick')]
    public function detailTrick(Trick $trick)
    {
        return $this->render('trick/detailTrick.html.twig', [
            'trick' => $trick,
        ]);
    }
}
