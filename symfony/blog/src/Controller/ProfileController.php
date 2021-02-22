<?php

namespace App\Controller;

use App\Form\PasswordModifyFormType;
use App\Form\PictureModifyFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile_index")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('profile/index.html.twig');
    }

    /**
     * @Route("/view/{username}", name="profile_view")
     */
    public function view(string $username, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(["username" => $username]);

        if (!$user) {
            $this->createNotFoundException('No user found with username ' . $username);
        }

        return $this->render('profile/view.html.twig', ["user" => $user]);
    }

    /**
     * @Route("/password-modify", name="profile_password_modify")
     */
    public function modifyPassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        //on refuse l'accès aux non-connectés
        $this->denyAccessUnlessGranted('ROLE_USER');

        //récup user connecté
        $user = $this->getUser();
        //crée notre formulaire a partir de notre formtype
        $form = $this->createForm(PasswordModifyFormType::class, $user);
        //on lit la requête
        $form->handleRequest($request);

        //si on est dans le cas où le formulaire a été envoyé
        if ($form->isSubmitted() && $form->isValid()) {
            //on remplace l'ancien mot de passe par le nouveau
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $form->get('newPassword')->getData()
                )
            );

            //on sauvegarde
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            //on redirige
            return $this->redirectToRoute('profile_index');
        }

        //sinon on affiche le formulaire 
        return $this->render(
            'profile/modifyPassword.html.twig',
            [
                "passwordModifyForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/picture-modify", name="profile_picture_modify")
     */
    public function modifyPicture(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        $form = $this->createForm(PictureModifyFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //handle profile picture upload
            $pictureFile = $form->get('pictureFile')->getData();
            $deletePicture = $form->get('deletePicture')->getData();

            //si on a reçu un fichier et qu'on ne souhaite pas revenir à l'image par défaut
            if ($pictureFile && !$deletePicture) {
                $fileName = md5(uniqid(rand())) . "." . $pictureFile->guessExtension();
                $fileDestination = $this->getParameter('user_profile_pictures_dir');
                try {
                    $pictureFile->move($fileDestination, $fileName);
                } catch (FileException $e) {
                    //renvoie une erreur http 500 - internal server error
                    throw new HttpException(500, 'An error occured during file upload');
                }
                //si l'image n'était pas l'image par défaut
                if ($user->getPicture() != 'default.png') {
                    //on supprime l'ancienne image du serveur
                    $this->removeProfilePicture($user->getPicture());
                }
                //on enregistre enfin le nom de l'image dans notre entité User
                $user->setPicture($fileName);
            }

            //si l'utilisateur décide de supprimer son image
            if ($deletePicture) {
                //on retire l'image
                $this->removeProfilePicture($user->getPicture());
                //et on donne l'image par défaut à l'utilisateur
                $user->setPicture('default.png');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/modifyPicture.html.twig', ['modifyPictureForm' => $form->createView()]);
    }

    private function removeProfilePicture(string $path)
    {
        $fs = new Filesystem();
        try {
            $fs->remove($this->getParameter('user_profile_pictures_dir') . '/' . $path);
        } catch (IOException $e) {
            throw new HttpException(500, 'An error occured during file upload');
        }
    }
}
