<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Advert;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;

class AdvertController extends AbstractController
{
    /**
     * @Route("/advert", name="advert")
     */
    public function index()
    {
        //récupération des advert dans la base de données
        //d'abord récupérer le repository de Advert
        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        //on demande ensuite au repository de récuperer toutes les Adverts
        $adverts = $advertRepository->findAll(); //renvoie un tableau de Advert

        return $this->render(
            'advert/index.html.twig',
            [
                'adverts' => $adverts
            ]
        );
    }

    /**
     * @Route("/advert/{id}", name="advert_view", requirements={
     * "id" = "\d+"
     * })
     */
    public function view($id)
    {
        //on récupère le repository d'Advert
        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        //find permet de chercher un objet selon son id
        $advert = $advertRepository->find($id);

        //si aucune annonce trouvée on envoie vers une autre page
        if (is_null($advert)){
            return $this->render('advert/notFound.html.twig');
        }

        return $this->render(
            'advert/view.html.twig',
            [
                'advert' => $advert
            ]
        );
    }

    /**
     * @Route("/advert/add", name="advert_add")
     */
    public function add(Request $request)
    {
        //on refuse l'accès aux utilisateurs non connéctés
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        
        //on récupère l'utilisateur connecté
        $user = $this->getUser();

        //création d'une entité 
        $advert = new Advert();
        //on ajoute la timestamp du moment de la création
        $advert->setDate(time());
        //on renseigne aussi le pseudo de l'utilisateur
        $advert->setAuthor($user->getUsername());
        
        //on prépare notre formulaire à l'aide de FormBuilder
        //on renseigne quelle entité sera à hydrater par notre formulaire
        $form = $this->createFormBuilder($advert)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('submit', SubmitType::class, ['label' => 'Poster'])
            ->getForm();
        //on confie la requête au formulaire
        $form->handleRequest($request);

        //si le formulaire a été envoyé et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère les données du formulaire
            //et on hydrate notre advert
            $advert = $form->getData();

            //pour inscrire l'objet en base de données
            //il faut faire appel à l'EntityManager
            //On doit d'abord le récuperer
            $entityManager = $this->getDoctrine()->getManager();

            //on demande à l'Entity Manager d'écrire l'objet dans la base
            $entityManager->persist($advert);
            //on demande à l'entity Manager de nettoyer derrière lui
            $entityManager->flush();

            $this->addFlash('success', 'Annonce bien enregistrée !');

            return $this->redirectToRoute('advert_view', 
            ['id' => $advert->getId()]
            );
        }

        return $this->render('advert/add.html.twig', 
        [
           'advert_form' => $form->createView() 
        ]);
    }

    /**
     * @Route("/advert/delete/{id}", name="advert_delete", 
     * requirements={
     *  "id" = "\d+"
     * })
     */
    public function delete($id){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        //on récupère l'utilisateur
        $user = $this->getUser();

        //on va chercher l'annonce à supprimer
        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        $advert = $advertRepository->find($id);

        //si l'auteur de l'annonce n'est pas 
        //l'utilisateur actuel
        if ($advert->getAuthor() != $user->getUsername()){
            //on redirige vers l'annonce 
            return $this->redirectToRoute('advert_view',
            [
                'id' => $advert->getId()
            ]);
        }

        //si l'annonce existe
        if (!is_null($advert)){
            //on la supprime 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($advert);
            $entityManager->flush();
            
            $this->addFlash('success', 'Annonce supprimée.');
        }
        //on redirige ensuite vers l'accueil
        return $this->redirectToRoute('advert');
    }

    /**
     * @Route("/advert/edit/{id}", name="advert_edit", 
     * requirements={
     *  "id" = "\d+"
     * })
     */
    public function edit($id, Request $request){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        //on va chercher l'annonce
        $advertRepository = $this->getDoctrine()->getRepository(Advert::class);
        $advert = $advertRepository->find($id);
        
        if (!is_null($advert)){
            //on prépare notre formulaire à l'aide de FormBuilder
            //on renseigne quelle entité sera à hydrater par notre formulaire
            $form = $this->createFormBuilder($advert)
                ->add('title', TextType::class)
                ->add('content', TextareaType::class)
                ->add('author', TextType::class)
                ->add('submit', SubmitType::class, ['label' => 'Poster'])
                ->getForm();
            //on confie la requête au formulaire
            $form->handleRequest($request);
    
            //si le formulaire a été envoyé et qu'il est valide
            if ($form->isSubmitted() && $form->isValid()) {
                //on récupère les données du formulaire
                //et on hydrate notre advert
                $advert = $form->getData();
    
                //pour inscrire l'objet en base de données
                //il faut faire appel à l'EntityManager
                //On doit d'abord le récuperer
                $entityManager = $this->getDoctrine()->getManager();
    
                //on demande à l'Entity Manager d'écrire l'objet dans la base
                $entityManager->persist($advert);
                //on demande à l'entity Manager de nettoyer derrière lui
                $entityManager->flush();

                $this->addFlash('success', 'Annonce modifée avec succès.');
    
                return $this->redirectToRoute('advert_view', 
                ['id' => $advert->getId()]
                );
            }
        } else {
            return $this->render('advert/notFound.html.twig');
        }

        return $this->render('advert/edit.html.twig', [
            'advert_form' => $form->createView()
        ]);
    }
}
