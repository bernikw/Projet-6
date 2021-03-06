<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

 
class HomeController extends AbstractController
{
    
    #[Route('/', name: 'app_home')]
    public function index(Request $request, PaginationService $pagination): Response
    { 
        $page = $request->query->getInt('page', 1);  
        $pagination->createPagination(Trick::class, [], ['createdAt'=> 'DESC'], $page, 15);
        

        return $this->render('home.html.twig', [
            'tricks' => $pagination->getData(),
            'nextPage' => $pagination->nextPage()
        ]);
    }
   
}
