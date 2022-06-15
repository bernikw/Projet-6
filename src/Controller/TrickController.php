<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Video;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Service\PaginationService;
use App\Repository\TrickRepository;
use App\Repository\PictureRepository;
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
    public function create(Request $request, EntityManagerInterface $entitymanager): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setCreatedAt(new \DateTimeImmutable);
            $trick->setSlug($form->get('name')->getData());
            $trick->setUser($this->getUser());
            $pictures = $form->get('pictures')->getData();
            

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
            
            foreach ($trick->getVideos() as $video) {
                $video->setTrick($trick);
            }

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


    #[Route('/{slug}', name: 'app_detail')]
    public function detail(Trick $trick, Request $request, EntityManagerInterface $entitymanager, PaginationService $pagination): Response
    {

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

        $page = $request->query->getInt('page', 1);  
        $pagination->createPagination(Comment::class, [], ['createdAt'=> 'DESC'], $page, 10);

        return $this->render(
            'trick/detail.html.twig',
            [
                'trick' => $trick,
                'comments' => $pagination->getData(),
                'nextPage' => $pagination->nextPage(),
                'commentForm' => $form->createView()
            ]
        );
    }

    #[Route('/edit/{slug}', name: 'app_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(Trick $trick, Request $request, EntityManagerInterface $entitymanager): Response
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
                $picture->setMain(false);
                $trick->addPicture($picture);
            }
 
            foreach ($trick->getVideos() as $video) {
                $video->setTrick($trick);
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

        $namePicture = $this->getParameter('images_directory') . '/' . $picture->getFilename();

        if (file_exists($namePicture)) {
            unlink($namePicture);
        }
        

        $entitymanager->remove($picture);
        $entitymanager->flush();

        $this->addFlash(
            'success',
            'La photo a bien été supprimé !'
        );


        return $this->redirectToRoute('app_home');
    }

    #[Route('/main/picture/{id}', name: 'app_main_picture')]
    #[IsGranted('ROLE_USER')]
    public function isMain(Picture $picture, PictureRepository $pictureRepository, EntityManagerInterface $entitymanager)
    {
       
       $pictures = $pictureRepository->findBy(['trick'=> $picture->getTrick()]);
       foreach ($pictures as $image) {
        $image->setMain(0);

        }
            
            $picture->setMain(1);      
       
        $entitymanager->persist($picture);
        $entitymanager->flush();

        $this->addFlash(
            'success',
            "Cet photo est devenue le photo main"
        );

        return $this->redirectToRoute('app_home');
    
    }

    #[Route('/delete/video/{id}', name: 'app_delete_video')]
    #[IsGranted('ROLE_USER')]
    public function deleteVideo(Video $video, EntityManagerInterface $entitymanager)
    {
        
      
        $entitymanager->remove($video);
        $entitymanager->flush();

        $this->addFlash(
            'success',
            'La video a bien été supprimé !'
        );


        return $this->redirectToRoute('app_home');
    }
}
