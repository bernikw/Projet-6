<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick', name: 'app_trick_')]
class TrickController extends AbstractController
{
    #[Route('/', name: 'app_list')]
    public function list(): Response
    {
        return $this->render('trick/list.html.twig');
    }

    #[Route('/{slug}', name: 'detail')]
    public function detail(Trick $trick)
    {
      
        $pictures = $trick->getPictures();
    
       
        return $this->render('trick/detail.html.twig', [
            'trick' => $trick,
            'pictures' => $pictures,       
        ]);
    }

    
    #[Route('/', name: 'create')]
    public function create()
    {
           
        return $this->render('trick/create.html.twig');
    }


    #[Route('/edit/{slug}', name: 'edit')]
    public function edit(Trick $trick)
    {
             
       
        return $this->render('trick/edit.html.twig', [
            'trick'=> $trick   
        ]);
    }

    #[Route('/delete/{slug}', name: 'delete')]
    public function delete(Trick $trick)
    {
             
       
        return $this->redirectToRoute('app_home');
    }
}
