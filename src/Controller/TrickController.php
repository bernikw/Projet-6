<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick', name: 'app_trick_')]
class TrickController extends AbstractController
{
    #[Route('/', name: 'app_list')]
    public function list(TrickRepository $trickRepository): Response
    {

        return $this->render('trick/list.html.twig', [
            'tricks' => $trickRepository->findBy([], ['createdAt' => 'DESC'], 10)
        ]);
    }

    #[Route('/{slug}', name: 'detail')]
    public function detail(Trick $trick, Request $request, EntityManagerInterface $entitymanager): Response
    {

        $pictures = $trick->getPictures();

        /* Partie commentaires */

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $comment->setCreatedAt(new \DateTimeImmutable);
            $comment->setUser($this->getUser());
            $comment->setTrick($trick);

            $entitymanager->persist($comment);
            $entitymanager->flush();

            $this->addFlash(
                'success',
                "Votre message a été posté avec succès"
            );

            return $this->redirectToRoute('app_trick_detail', [
                'slug'=> $trick->getSlug()
            ]);

        }

        return $this->render('trick/detail.html.twig', [
            'trick' => $trick,
            'pictures' => $pictures,
            'commentForm' =>  $form->createView()
        ]);
    }

    #[Route('/create', name: 'app_create')]
    public function create(Request $request, EntityManagerInterface $entitymanager): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCreatedAt(new \DateTimeImmutable);
            $trick->setSlug($form->get('name')->getData());
            $trick->setUser($this->getUser());

            $entitymanager->persist($trick);
            $entitymanager->flush();

            $this->addFlash(
                'success',
                "Votre trick a été posté avec succès"
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('trick/create.html.twig', [
            'trickForm' => $form->createView()
        ]);
    }


    #[Route('/edit/{slug}', name: 'edit')]
    public function edit(Trick $trick, Request $request, EntityManagerInterface $entitymanager): Response
    {

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdatedAt(new \DateTimeImmutable);
            $trick->setSlug($form->get('name')->getData());
            $trick->setUser($this->getUser());

            $entitymanager->persist($trick);
            $entitymanager->flush();

            $this->addFlash(
                'success',
                "Votre trick a été modifié avec succès"
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('trick/edit.html.twig', [
            'trickForm' => $form->createView()
        ]);
    }

    #[Route('/delete/{slug}', name: 'delete')]
    public function delete(Trick $trick, EntityManagerInterface $entitymanager): Response
    {
        if(!$trick){
            $this->addFlash(
                'danger',
                "Le trick n\'a pas trouvé"
            );
        }

        $entitymanager->remove($trick);
        $entitymanager->flush();

        $this->addFlash('success', 
        'Le trick a bien été supprimé !');

        return $this->redirectToRoute('app_home');
    }
}
