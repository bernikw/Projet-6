<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Video;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
            'tricks' => $trickRepository->findBy([], ['createdAt' => 'DESC'])
        ]);
    }


    #[Route('/create', name: 'app_create')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, VideoRepository $videoRepository, EntityManagerInterface $entitymanager): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setCreatedAt(new \DateTimeImmutable);
            $trick->setSlug($form->get('name')->getData());
            $trick->setUser($this->getUser());
            $pictures = $form->get('pictures')->getData();
            $videos = $form->get('videos')->getData();

            $isMain = true;

            foreach ($pictures as $picture) {

                $file = md5(uniqid()) . '.' . $picture->guessExtension();

                $picture->move(
                    $this->getParameter('images_directory'),
                    $file
                );

                $picture = new Picture();
                $picture
                    ->setFilename($file)
                    ->setMain($isMain);
                if ($isMain) {
                    $isMain = false;
                }
                $trick->addPicture($picture);
            }

            foreach ($videos as $video) {
                
                $videoRepository->add($video);
            }

            $entitymanager->persist($trick);
            $entitymanager->flush();

            $this->addFlash(
                'success',
                "Votre trick a été posté avec succès"
            );

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trick/create.html.twig', [
            'trickForm' => $form->createView()
        ]);
    }


    #[Route('/{slug}', name: 'app_detail')]
    public function detail(Trick $trick, Request $request, EntityManagerInterface $entitymanager): Response
    {

        $pictures = $trick->getPictures();
        $videos = $trick->getVideos();

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setCreatedAt(new \DateTimeImmutable);
            $comment->setUser($this->getUser());
            $comment->setTrick($trick);

            $entitymanager->persist($comment);
            $entitymanager->flush();

            $this->addFlash(
                'success',
                "Votre message a été posté avec succès"
            );

            return $this->redirectToRoute('app_trick_app_detail', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render(
            'trick/detail.html.twig',
            [
                'trick' => $trick,
                'pictures' => $pictures,
                'videos' => $videos,
                'comments' => $trick->getComments(),
                'commentForm' => $form->createView()
            ]
        );
    }


    /* #[Route('/comments{slug}', name: 'app_comments')]
    public function loadComments(CommentRepository $commentRepository, Request $request) 
    {
        $limit = 1;
        $page = (int)$request->query->get("page", 1);

        $comments = $commentRepository->getPaginatedComments($page, $limit);

        $total = $commentRepository->getTotalComments();

        return $this->render('app_trick_detail', [
            'comments'=> $comments,
            'total' => $total,
            'limit' => $limit,
            'page' => $page
    ]);
      
    }*/


    #[Route('/edit/{slug}', name: 'app_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(Trick $trick, Request $request, VideoRepository $videoRepository, EntityManagerInterface $entitymanager): Response
    {

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdatedAt(new \DateTimeImmutable);
            $trick->setSlug($form->get('name')->getData());
            $trick->setUser($this->getUser());

            $pictures = $form->get('pictures')->getData();

            foreach ($pictures as $picture) {

                $file = md5(uniqid()) . '.' . $picture->guessExtension();

                $picture->move(
                    $this->getParameter('images_directory'),
                    $file
                );

                $picture = new Picture();
                $picture->setFilename($file);
                $trick->addPicture($picture);
            }



            $videos = $form->get('videos')->getData();

            foreach ($videos as $video) {
                if ($video->getUrl() !== null) {
                    //$videoRepository->add($video);
                    $video = new Video();
                    $video->setUrl($video->getUrl());
                    $entitymanager->persist($video);

                    return $this->redirectToRoute('app_home');
                }
            }

            $entitymanager->persist($trick);
            $entitymanager->flush();

            $this->addFlash(
                'success',
                "Votre trick a été modifié avec succès"
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'trickForm' => $form->createView()
        ]);
    }

    #[Route('/delete/{slug}', name: 'app_delete')]
    #[IsGranted('ROLE_USER')]
    public function delete(Trick $trick, EntityManagerInterface $entitymanager): Response
    {
        if (!$trick) {
            $this->addFlash(
                'danger',
                "Le trick n\'a pas trouvé"
            );
        }

        $pictures = $trick->getPictures();

        if ($pictures) {
            foreach ($pictures as $picture) {
                $namePicture = $this->getParameter('images_directory') . '/' . $picture->getFilename();

                if (file_exists($namePicture)) {
                    unlink($namePicture);
                }
            }
        }

        $entitymanager->remove($trick);
        $entitymanager->flush();

        $this->addFlash(
            'success',
            'Le trick a bien été supprimé !'
        );

        return $this->redirectToRoute('app_home');
    }

    #[Route('/delete/picture/{id}', name: 'app_delete_picture')]
    #[IsGranted('ROLE_USER')]
    public function deletePicture(Picture $picture, EntityManagerInterface $entitymanager)
    {

        $picture = $picture->getFilename();

        if (file_exists($picture)) {
            unlink($this->getParameter('images_directory') . '/' . $picture);
        }

        $entitymanager->remove($picture);
        $entitymanager->flush();

        $this->addFlash(
            'success',
            'La photo a bien été supprimé !'
        );


        return $this->redirectToRoute('app_home');
    }

    #[Route('/delete/video/{id}', name: 'app_delete_video')]
    #[IsGranted('ROLE_USER')]
    public function deleteVideo(Video $video, EntityManagerInterface $entitymanager)
    {
        $video = $video->getUrl();

        if (file_exists($video)) {
            unlink($this->getParameter('images_directory') . '/' . $video);
        }

        $entitymanager->remove($video);
        $entitymanager->flush();

        $this->addFlash(
            'success',
            'Le video a bien été supprimé !'
        );


        return $this->redirectToRoute('app_home');
    }
}
