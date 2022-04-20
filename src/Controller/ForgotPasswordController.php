<?php

namespace App\Controller;

use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\SendEmailService;


class ForgotPasswordController extends AbstractController
{

    #[Route('/forgot/password', name: 'app_forgot_password')]
    public function sendRecoveryLink(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, SendEmailService $mail): Response
    {

        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

        $email = $form->getData('email');    

        $user = $this->userRepository->findOneBy('email');

        if(!$user){

            $user->setValidatedToken(uniqid());

            $entityManager->persist($user);
            $entityManager->flush();

            $mail->send(
                'snowtricks@gmail.com',
                $user->getEmail(),
                'SnowTricks - Réinitilisation du mot de passe',
                'forgot_email',
                [
                    'user'=> $user,
                    'validatedToken'=> $user->getValidatedToken()
                ]
            );

            $this->addFlash('success', 
            "Un email vous a été envoyé pour réinitialiser un mot de passe !"
            );


        } else{

            $this->addFlash('danger', 
            "Cet utilisateur n'existe pas !"
            );
        }

        }

        return $this->render('forgot_password/forgot_email.html.twig', [
            'controller_name' => 'ForgotPasswordController',
        ]);
    }
}
