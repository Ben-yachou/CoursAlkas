<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

            //handle file upload
            $file = $form['profile_pic']->getData();

            if ($file) {
                //generate unique filename
                $filename = md5(uniqid()); 
                //concatenate filename with extension
                $fullFilename = $filename . '.' . $file->guessExtension();

                //move file to permanent destination
                try {
                    $file->move(    
                        $this->getParameter('image_directory'), 
                        $fullFilename
                    );
                    //saving filepath into database
                    $user->setProfilePic($fullFilename); 
                } catch (FileException $e){
                    //handle file exception
                }
            } else {
                //default user image in case nothing is sent 
                $user->setProfilePic('default.png');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
