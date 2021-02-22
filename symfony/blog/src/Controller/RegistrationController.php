<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //handle profile picture upload
            $pictureFile = $form->get('pictureFile')->getData();
            //si on a reçu un fichier
            if ($pictureFile) {
                //génération du nom de fichier aléatoire + extension devinée à partir du type MIME
                $fileName = md5(uniqid(rand())) . "." . $pictureFile->guessExtension();
                //on récupère le dossier des images utilisateurs tel que définit dans nos paramètres d'application dans config/services.yaml
                $fileDestination = $this->getParameter('user_profile_pictures_dir');

                //pictureFile étant de type UploadedFile on peut utiliser la méthode move() qui reproduit le comportement de move_uploaded_file en PHP 
                //le premier paramètre est le dossier de destination, le second est le nom final du fichier
                try {
                    $pictureFile->move($fileDestination, $fileName);
                } catch (FileException $e) {
                    //renvoie une erreur http 500 - internal server error
                    throw new HttpException(500, 'An error occured during file upload');
                }
            } else {
                //on donne le nom de l'image par défaut
                $fileName = 'default.png';
            }
            //on enregistre enfin le nom de l'image dans notre entité User
            $user->setPicture($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
