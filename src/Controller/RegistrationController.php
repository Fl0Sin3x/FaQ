<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegistrationFormType;
use App\Form\UpdatePasswordType;
use App\Form\EditProfilType;
use App\Entity\User;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SluggerInterface $slugger, User $user)
    {

        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile imageFilename */
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $filename = uniqid() . '.' . $picture->guessExtension();

                $picture->move(
                    $this->getParameter('images_directory'),
                    $filename
                );

                $user->setPicture($filename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Profil modifié.');

            return $this->redirectToRoute('app_profile');
        }
        return $this->render('registration/edit.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}/update_password', name: 'app_update_password', methods: ['GET', 'POST'])]
    public function updatePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, EntityManagerInterface $entityManager, User $user): Response
    {
        $form = $this->createForm(UpdatePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/update_password.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
