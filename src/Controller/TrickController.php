<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick', name: 'app_trick_')]
class TrickController extends AbstractController
{
    #[Route('/', name: 'app_list')]
    public function list(TrickRepository $trickRepository): Response
    {
        
        return $this->render('trick/list.html.twig',[ 
            'tricks'=> $trickRepository->findBy([], ['createdAt'=> 'DESC'], 10)
            ]);
    }

    #[Route('/create', name: 'app_create')]
    public function create(): Response
    {
      
        

        return $this->render('trick/create.html.twig');
    }

    #[Route('/{slug}', name: 'detail')]
    public function detail(Trick $trick): Response
    {
      
        $pictures = $trick->getPictures();
         
        return $this->render('trick/detail.html.twig', [
            'trick' => $trick,
            'pictures' => $pictures,       
        ]);
    }

    #[Route('/edit/{slug}', name: 'edit')]
    public function edit(Trick $trick): Response
    {
             
       
        return $this->render('trick/edit.html.twig', [
            'trick'=> $trick   
        ]);
    }

    #[Route('/delete/{slug}', name: 'delete')]
    public function delete(Trick $trick, EntityManagerInterface $entitymanager): Response
    {

        $entitymanager->remove($trick);
        $entitymanager->flush();

        $this->addFlash('success', 'Le trick a bien été supprimé !');
       
        return $this->redirectToRoute('app_home');
    }
}
