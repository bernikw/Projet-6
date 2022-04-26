<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TrickRepository $trickRepository): Response
    {
        
        $tricks = $trickRepository->findBy([], ['createdAt'=> 'DESC'], 10, 0);
        
        return $this->render('home.html.twig', [
            'tricks' => $tricks,
        ]);
    }
}
