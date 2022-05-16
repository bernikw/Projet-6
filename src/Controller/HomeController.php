<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/home', name: 'more_tricks')]
    public function loadTricks(TrickRepository $trickRepository, Request $request)
    {
        
        $page = (int)$request->query->get('page', 1);
         $limit = 5;

       $tricks = $trickRepository->getPaginatedTricks($page, $limit);

        return $this->render('loadTricks.html.twig', [
            'tricks' => $tricks
        ]);

    }
}
