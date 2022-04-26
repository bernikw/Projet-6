<?php

namespace App\Controller;

use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\SendEmailService;
use
    Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class ForgotPasswordController extends AbstractController
{

    #[Route('/forgot/password/', name: 'app_forgot_password')]
    public function sendRecoveryLink(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager,  SendEmailService $mail): Response
    {

        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = $form->getData('email');
            $user = $userRepository->findOneByEmail($email);

            if ($user !== null && $user->getActivated() === 1) {

                $user
                    ->setResetPasswordToken(uniqid());

                $entityManager->persist($user);
                $entityManager->flush();

                $mail->send(
                    'snowtricks@gmail.com',
                    $user->getEmail(),
                    'SnowTricks - Réinitilisation du mot de passe',
                    'forgot_email',
                    [
                        'user' => $user,
                        'resetPasswordToken' => $user->getResetPasswordToken()
                    ]
                );

                $this->addFlash(
                    'success',
                    "Un email vous a été envoyé pour réinitialiser un mot de passe !"
                );
            } else {

                $this->addFlash(
                    'danger',
                    "Cet utilisateur n'existe pas !"
                );
            }
        }

        return $this->render('forgot_password/forgot_password.html.twig', [
            'forgotForm' => $form->createView(),
        ]);
    }
    

    #[Route('/forgot/password/{pseudo}/{$resetPasswordToken}', name: 'app_reset_password')]
    public function resetPassword(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, $pseudo, $resetPasswordToken, EntityManagerInterface $entityManager)
    {
        $user = $userRepository->findOneByPseudo($pseudo);

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($user->getResetPasswordToken() === $resetPasswordToken) {
                
                $user
                    ->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );

                $user->setResetPasswordToken(null);

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a été changé avec success!"
                );

                return $this->redirectToRoute('app_login');

            }
        }
        return $this->render('forgot_password/reset_password.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}
