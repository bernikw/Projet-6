<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use App\Service\SendEmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Repository\UserRepository;



class RegistrationController extends AbstractController
{
 
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager, SendEmailService $mail): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user
            ->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            )
            ->setActivated(false)
            ->setValidatedToken(uniqid())
            ;

            $entityManager->persist($user);
            $entityManager->flush();

        
            // do anything else you need here, like send an email
            $mail->send(
                'snowtricks@gmail.com',
                $user->getEmail(),
                'Veuillez activer votre compte',
                'register_email',
                [
                    'user'=> $user,
                    'validatedToken'=> $user->getValidatedToken()
                ]
            );

            $this->addFlash('success',
                "Votre compte a été crée ! Veuillez activer votre compte en cliquant sur le lien qui vous a été envoyé par e-mail !"
            );

            return $this->redirectToRoute('app_login');
            
          
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify_account/{pseudo}/{validatedToken}', name: 'app_verify_account')] 
    public function verifyAccount(UserRepository $userRepository, $pseudo, $validatedToken,  EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->findOneByPseudo($pseudo);

        if($validatedToken !== null && $validatedToken === $user->getValidatedToken()){

            $user->setActivated(true);

            $user->setValidatedToken(null);

            $entityManager->flush($user);

            $this->addFlash('success',
                "Votre compte a été activé avec succès ! Vous pouvez désormais vous connecter !"
            );

        } else{

            $this->addFlash('danger',
                "Le compté a déjà été validé !"
            );  
        }

        return $this->redirectToRoute('app_home');
    }
}
