<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pizza")
 */
class PizzaController extends AbstractController
{
    /**
     * @Route("/", name="pizza_index", methods={"GET"})
     */
    public function index(PizzaRepository $pizzaRepository): Response
    {
        return $this->render('pizza/index.html.twig', [
            'pizzas' => $pizzaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pizza_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pizza = new Pizza();
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photoFile')->getData();

            //récupération de la déstination du fichier (notre dossier)
            $photoDestination = $this->getParameter('pizza_photos_dir');
            //récupération du nom de fichier
            $originalName = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
            //génération du nom final du fichier avec son extension (.jpg, .png) et un id unique pour éviter les doublons
            $photoName = uniqid($originalName) . "." . $photoFile->guessExtension();

            try {
                //on range la photo dans notre dossier d'upload pizza_photos
                $photoFile->move($photoDestination, $photoName);
            } catch (FileException $e) {
                throw new HttpException(500, 'An Error Occured during File Upload');
            }

            $pizza->setPhoto($photoName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pizza);
            $entityManager->flush();

            return $this->redirectToRoute('pizza_index');
        }

        return $this->render('pizza/new.html.twig', [
            'pizza' => $pizza,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pizza_show", methods={"GET"})
     */
    public function show(Pizza $pizza): Response
    {
        return $this->render('pizza/show.html.twig', [
            'pizza' => $pizza,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pizza_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pizza $pizza): Response
    {
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pizza_index');
        }

        return $this->render('pizza/edit.html.twig', [
            'pizza' => $pizza,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pizza_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pizza $pizza): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pizza->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pizza);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pizza_index');
    }
}
