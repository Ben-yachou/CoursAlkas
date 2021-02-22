<?php

//namespace permet de placer notre fichier dans un contexte précis de notre application, c'est à dire lui donner une sorte de "chemin" dans notre projet
//cela permet de le retrouver facilement (ici on pourrait taper use App\Controller\MainController pour avoir accès a notre class MainController partout dans l'application)
namespace App\Controller;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
//un use permet donc de récuperer un contexte extérieur pour pouvoir utiliser d'autres composants d'application
//ici on récupère AbstractController qui contient certaines fonctionnalités de base, utiles et propres aux Controlleurs dans Symfony
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
//Response est une classe représentant une réponse HTTP valide pour renvoi au client (le navigateur ici)
use Symfony\Component\HttpFoundation\Response;

//ce use ci permet d'utiliser les annotations de Route pour indiquer au Routeur comment atteindre notre controleur
use Symfony\Component\Routing\Annotation\Route;

//Notre classe MainController permet de définir notre controleur dans le cadre de notre architecture Modele Vue Controleur
//Le nom doit correspondre au nom du fichier .php à 100% et doit toujours se finir par Controller
//on extends AbstractController pour pouvoir utiliser les fonctionnalités de la classe abstraite déjà prévues par symfony
class MainController extends AbstractController
{

    //pour définir une route on peut utiliser une annotation telle que la suivante
    //on associe un chemin (une url) avec une méthode, et on nomme cette association pour pouvoir l'identifier facilement
    //ici notre route lie le chemin "/" avec la méthode index() de notre controller, et cette route s'apppelle "index"
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        //sur notre page d'accueil on veut afficher les articles stockés dans notre bdd
        //pour pouvoir aller chercher des données il faut demander à Doctrine
        //et plus particulièrement à un EntityRepository
        //Le Repository agit comme un "dépot" de données, et il en existe une instance pour chaque entité 
        //Pour récupérer des articles, on va récupérer une instance d'ArticleRepository

        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        //on demande ensuite à ArticleRepository de nous renvoyer nos articles
        //findAll renvoie un tableau d'entités
        // $articles = $articleRepository->findAll()

        //si on veut pouvoir utiliser OrderBy on peut utiliser find by sans critères, ce qui permet de faire essentiellement findAll
        //puis rajouter une option orderBy en deuxième paramètre
        $articles = $articleRepository->findBy([], ['createdAt' => 'DESC']);

        //notre méthode index doit renvoyer une HttpFoundation\Response
        //la méthode render prévue dans AbstractController se charge de générer une Response a partir d'un template twig
        //le premier paramètre définit le template dont le rendu doit être effecuté
        //le deuxième paramètre définit les variables que l'on souhaite transferer au template
        return $this->render(
            'main/index.html.twig',
            [
                //on peut envoyer nos articles de cette façon à notre template, $articles étant un tableau
                "articles" => $articles
            ]
        );
    }

    //127.0.0.1:8000/article/1 donnera un id = 1
    /**
     * @Route("/article/{id}", name="view")
     */
    public function view(int $id): Response
    {
        //notre fonction view possède un paramètre nommé id, en indiquant dans notre annotation de route un paramètre nommé également {id}, le routeur se chargera de faire la correspondance entre la valeur trouvée à cet endroit dans la route, et notre paramètre $id
        //l'id se trouvera donc dans notre variable $id
        //on utilise ensuite ce paramètre pour aller chercher notre article

        //pour ce faire, on utilise le repository
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        //Pour aller chercher une entité en particulier on utilise find avec comme paramètre notre $id
        $article = $articleRepository->find($id); //find permet de chercher par id et renvoie un objet Article ici 

        //on vérifie que notre article ait bien été récupéré
        if (!$article) {
            //si ce n'est pas le cas on envoie une exception NotFoundHttpException
            throw $this->createNotFoundException("Article does not exist");
        }

        return $this->render(
            'main/view.html.twig',
            //"article" ici représente le nom qu'aura la variable dans notre template twig
            ["article" => $article]
        );
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        //pour refuser un accès à une fonctionnalité en se basant sur la connexion ou non connexion, ou sur le rôle d'un utilisateur connecté
        //on peut utiliser denyAccessUnlessGranted qui vérifie si un certain attribut est octroyé au jeton présemment enregistré dans la session (potentiellement un user)
        //Plusieurs de ces attributs existent pour gérer les connexions
        //IS_AUTHENTICATED, permet de voir si quelqu'un est authentifié, mais c'est le cas également des anonymes dans notre application
        //IS_AUTHENTICATED_FULLY, permet de voir si quelqu'un est passé par un de nos authenticator pour se connecter (en gros si quelqu'un est passé par notre LoginForm)
        //IS_AUTHENTICATED_REMEMBERED, même chose qu'au dessus mais prend également en compte les gens qui ont coché l'option "se souvenir de moi" lors de la connexion
        //On peut également utiliser comme atribut ROLE_USER, qui est le rôle donné à tous les utilisateurs connectés
        $this->denyAccessUnlessGranted('ROLE_USER');
        //si l'utilisateur n'est pas connecté, le reste du code ne s'executera pas et l'utilisateur sera redirigé vers la page de connexion

        //on prépare un article vide qu'on hydratera à l'aide d'un formulaire
        $article = new Article();

        //on prépare ensuite un formulaire de création d'article
        //pour ce faire on utilise un composant de symfony appelé FormBuilder
        //en utilisant createFormBuilder de AbstractController on peut mettre en place un formulaire dynamique
        //ce formulaire va être créé pour notre objet $article 
        //chaque appel de add rajoute un champ de formulaire qu'on peut personnaliser
        //on personnalise le formulaire puis on récupère celui ci avec getForm()
        $form = $this->createFormBuilder($article)
            ->add('title')
            ->add('content', CKEditorType::class, ['config' => [
                'filebrowserBrowseRouteParameters' => [
                    'homeFolder' => $this->getUser()->getUsername()
                ]
            ]])
            ->add('submit', SubmitType::class, ['label' => 'Create Article'])
            ->getForm();

        //pour traiter la requête HTTP et savoir si le formulaire a été envoyé, ou si on doit simplement l'afficher, on utilise handleRequest qui jettera un oeil a la méthode de la requête ainsi qu'aux paramètres de la requête.
        //si la méthode convient et que les paramètres ont été trouvés, le Form se chargera de ranger toutes les valeurs trouvées dans notre entité Article
        $form->handleRequest($request); //charge les données de la requête dans le Form
        //une fois que la requête a été inspectée, on peut vérifier si le formulaire a éte envoyé et s'il est valide, et si c'est le cas on peut entreprendre d'enregistrer notre Article
        if ($form->isSubmitted() && $form->isValid()) {
            //isSubmitted verifie qu'on soit en POST, isValid vérifie l'intégrité du formulaire et des règles de validation (qu'on peut personnaliser)

            //pour récupérer l'utilisateur connecté on utilise 
            $user = $this->getUser();
            //on donne ensuite l'user connecté comme auteur
            $article->setAuthor($user);

            //on gère la date de création
            $article->setCreatedAt(new \DateTime());

            //on enregistre notre Article dans la base à l'aide de l'entityManager
            $entityManager = $this->getDoctrine()->getManager(); //getManager récupère l'EM
            $entityManager->persist($article); //persist permet à doctrine d'entamer le suivi de notre entité
            $entityManager->flush(); //flush permet de synchroniser doctrine et la base de données, ici ça effectue un "commit" enregistrant notre Article

            //pour rediriger à la suite de notre enregistrement on peut utiliser redirectToRoute
            //qui permet d'effectuer une redirection vers une autre route de notre site 
            //ici en précisant qu'on désire aller vers "view" avec un id = $article->getId() on renvoie vers la vue unique de notre nouvel article
            return $this->redirectToRoute("view", ["id" => $article->getId()]);
        }

        //si on est en GET, on arrivera à ce return qui se contente de renvoyer la vue de notre template main/create.html.twig avec comme paramètre une FormView générée à partir de $form
        return $this->render(
            'main/create.html.twig',
            [
                "createForm" => $form->createView()
            ]
        );
    }


    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(int $id, Request $request): Response
    {

        //empêche l'accès aux utilisateurs non connectés
        $this->denyAccessUnlessGranted('ROLE_USER');

        //récupération de notre article pour modification
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);


        //on vérifie que notre article ait bien été récupéré
        if (!$article) {
            //si ce n'est pas le cas on envoie une exception NotFoundHttpException
            throw $this->createNotFoundException("Article does not exist");
        }

        //si l'utilisateur n'est pas l'auteur on renvoie une AccessDeniedException (erreur 403 - Forbidden)
        if ($article->getAuthor() != $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        //création de notre formulaire à partir de notre article
        $form = $this->createFormBuilder($article)
            ->add('title')
            ->add('content', CKEditorType::class, [
                'config' => [
                    'filebrowserBrowseRouteParameters' => [
                        'homeFolder' => $this->getUser()->getUsername()
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Update Article'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on n'a pas besoin de lancer persist() sur ntore $article, car celui ci est déjà suivi par doctrine
            //cependant on doit bien utiliser flush() pour que les modifications soient appliquées en base de données
            $this->getDoctrine()->getManager()->flush();

            //on redirige ensuite vers l'article à l'aide de son id
            return $this->redirectToRoute('view', ['id' => $article->getId()]);
        }

        return $this->render('main/update.html.twig', ['updateForm' => $form->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(int $id): Response
    {
        //Refus d'accès aux non connectés
        $this->denyAccessUnlessGranted('ROLE_USER');

        //récupération de notre article pour suppression
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        //on vérifie que notre article ait bien été récupéré
        if (!$article) {
            //si ce n'est pas le cas on envoie une exception NotFoundHttpException
            throw $this->createNotFoundException("Article does not exist");
        }

        //si l'utilisateur n'est pas l'auteur on renvoie une AccessDeniedException (erreur 403 - Forbidden)
        if ($article->getAuthor() != $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        //on récupère l'entityManager
        $em = $this->getDoctrine()->getManager();
        //remove permet d'arrêter le suivi d'une entité par Doctrine, et a donc pour effet de la supprimer de la base une fois qu'on exécute flush
        $em->remove($article);
        $em->flush();

        //on redirige ensuite vers l'accueil
        return $this->redirectToRoute('index');
    }
}
