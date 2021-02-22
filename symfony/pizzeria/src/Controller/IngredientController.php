<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ingredient")
 */
class IngredientController extends AbstractController
{
    /**
     * @Route("/", name="ingredient")
     */
    public function index(): Response
    {
        $ingredientRepository = $this->getDoctrine()->getRepository(Ingredient::class);
        $ingredients = $ingredientRepository->findAll();

        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }

    /**
     * @Route("/create", name="ingredient_create")
     */
    public function create(Request $request): Response
    {

        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientFormType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager =  $this->getDoctrine()->getManager();
            $entityManager->persist($ingredient);
            $entityManager->flush();
        }

        return $this->render(
            'ingredient/create.html.twig',
            [
                'ingredientForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/update/{id}", name="ingredient_update")
     */
    public function update(Ingredient $ingredient, Request $request): Response
    {
        $form = $this->createForm(IngredientFormType::class, $ingredient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('ingredient');
        }
        return $this->render(
            'ingredient/update.html.twig',
            [
                'ingredientForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/delete/{id}", name="ingredient_delete")
     */
    public function delete(Ingredient $ingredient, EntityManagerInterface $em)
    {
        $em->remove($ingredient);
        $em->flush();

        return $this->redirectToRoute('ingredient');
    }
}
