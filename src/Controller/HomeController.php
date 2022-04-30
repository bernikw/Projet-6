<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * This function display homepage
     * 
     * @param TrickRepository $trickRepository
     * @return Response
     */

    #[Route('/', name: 'app_home')]
    public function index(TrickRepository $trickRepository): Response
    {
             
        return $this->render('home.html.twig', [
            'tricks' => $trickRepository->findBy([], ['createdAt'=> 'DESC'], 10)
    
        ]);
    }
}
