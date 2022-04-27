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

    #[Route('/{slug}', name: 'detail')]
    public function detail(Trick $trick)
    {

        $pictures = $trick->getPictures();

        return $this->render('trick/detail.html.twig', [
            'trick' => $trick,
            'pictures' => $pictures
        ]);
    }
}
