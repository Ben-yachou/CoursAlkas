<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Comment;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog_index")
     */
    public function index()
    {
        //pour pouvoir dialoguer avec la base de données via Doctrine
        //il faut faire appel au Repository en charge de l'objet à manipuler
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        //on demande ensuite à ce Repository de récuperer nos articles en BDD
        $articles = $articleRepository->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/view/{id}", name="blog_view", requirements={
     *  "id" = "\d+"
     * })
     */
    public function view($id)
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $article = $articleRepository->find($id);
        
        if (is_null($article)){
            return $this->redirectToRoute('blog_not_found');
        }

        //on récupère les commentaires de l'article
        $comments = $article->getComments();

        return $this->render('blog/view.html.twig', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/add", name="blog_add")
     */
    public function add(Request $request)
    {
        //on refuse l'accès aux utilisateurs non connectés
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        
        //on récupère l'utilisateur connecté
        $user = $this->getUser();

        //création d'une entité 
        $article = new Article();
        $article->setSubmitDate(new \DateTime());
        $article->setAuthor($user);

        //on prépare notre formulaire à l'aide de FormBuilder
        //on renseigne quelle entité sera concernée par notre formulaire
        $form = $this->createFormBuilder($article)
                    ->add('title', TextType::class)
                    ->add('content', TextareaType::class)
                    ->add('image', FileType::class, ['label' => "Image (jpg, png)"])
                    ->add('submit', SubmitType::class, ['label' => "Poster Article"])
                    ->getForm();
        //on demande au formulaire de traiter la requête HTTP
        $form->handleRequest($request);
        //si le formulaire a été envoyé et si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()){ 
            //alors on peut traiter l'enregistrement des données dans la base
            //on commence le traitement du téléchargement de l'image
            //d'abord on récupère les données de l'image
            $file = $form->get('image')->getData();

            //ensuite on génère un nom pour cette image
            //on hache un identifiant unique pour avoir une string unique
            $uniqueName = md5(uniqid()); 
            //on génère ensuite le nom de fichier avec son extension
            $filename = $uniqueName . '.' . $file->guessExtension();

            //on va maintenant essayer d'enregistrer l'image sur notre serveur
            try {
                $file->move(
                    $this->getParameter('image_directory'),
                    $filename
                );
            } catch (FileException $exception) {
                //TODO gérer l'erreur de fichier
            }
            //on enregistre ensuite le chemin du fichier dans notre article
            $article->setImage($filename);

            //on enregistre l'article dans la BDD
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            //on redirige une fois l'article enregistré, vers la vue de l'article
            return $this->redirectToRoute('blog_view', [
                "id" => $article->getId()
            ]);
        }

        return $this->render('blog/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="blog_edit", requirements={
     *  "id" = "\d+"
     * })
     */
    public function edit($id, Request $request){
        //refuser l'accès aux utilisateurs non connectés
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $user = $this->getUser();

        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $article = $articleRepository->find($id);

        if (is_null($article)){
            return $this->redirectToRoute('blog_not_found');
        }

        //si l'auteur de l'article ne correspond pas a l'utilisateur connecté
        if ($article->getAuthor()->getUsername() != $user->getUsername()) {
            //on redirige
            return $this->redirectToRoute('blog_view', 
            [
                'id' => $article->getId()
            ]);
        }

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('image', FileType::class, ['label' => 'Poster nouvelle image', 'mapped' => false, 'required' => false])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){  
            //alors on peut traiter l'enregistrement des données dans la base
            //on commence le traitement du téléchargement de l'image
            //d'abord on récupère les données de l'image
            $file = $form->get('image')->getData();
            
            //si on a bien reçu un fichier
            if (!is_null($file)){
                //ensuite on génère un nom pour cette image
                //on hache un identifiant unique pour avoir une string unique
                $uniqueName = md5(uniqid()); 
                //on génère ensuite le nom de fichier avec son extension
                $filename = $uniqueName . '.' . $file->guessExtension();
    
                //on va maintenant essayer d'enregistrer l'image sur notre serveur
                try {
                    $file->move(
                        $this->getParameter('image_directory'),
                        $filename
                    );
                } catch (FileException $exception) {
                    //TODO gérer l'erreur de fichier
                }
                //on enregistre ensuite le chemin du fichier dans notre article
                $article->setImage($filename);
            }
            //on termine les opérations avec doctrine
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_view', [
                "id" => $article->getId()
            ]);
        }

        return $this->render('blog/edit.html.twig', [
            'edit_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="blog_delete", requirements={
     *  "id" = "\d+"
     * })
     */
    public function delete($id){
        //on refuse l'accès aux utilisateurs non connectés
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        //on récupère l'utilisateur
        $user = $this->getUser();

        //on récupère l'article via le repository
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $article = $articleRepository->find($id);

        //si on a pas trouvé d'article on redirige
        if (is_null($article)){
            return $this->redirectToRoute('blog_not_found');
        }

        //si l'auteur de l'article ne correspond pas a l'utilisateur connecté
        if ($article->getAuthor()->getUsername() != $user->getUsername()) {
            //on redirige
            return $this->redirectToRoute('blog_view', 
            [
                'id' => $article->getId()
            ]);
        }

        //on récupère le manager
        $entityManager = $this->getDoctrine()->getManager();
        //on supprime tous les commentaires attachés à l'article
        $comments = $article->getComments();
        foreach ($comments as $comment) {
            $entityManager->remove($comment);
        }
        //on supprime enfin l'article
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('blog_index');
    }

    //cette fonction n'a pas de route car elle va être appellée
    //directement depuis le template d'une autre fonction
    //(dans ce cas, le template view.html.twig)
    public function comment($article){
        //on refuse l'accès aux utilisateurs non connectés
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        
        //on récupère l'utilisateur connecté
        $user = $this->getUser();

        $comment = new Comment();
        $comment->setAuthor($user);
        $comment->setSubmitDate(new \DateTime());
        $comment->setArticle($article);

        $form = $this->createFormBuilder($comment)
                    ->add('content', TextareaType::class)
                    ->add('submit', SubmitType::class, ['label' => 'Commenter'])
                    ->getForm();

        //ici on doit récupérer non pas la requête liée à cette fonction
        //mais la requête qui a amené sur la page intégrant cette fonction
        //c'est à dire la requête concernant la fonction view()
        //Donc on récupère la "masterRequest" ou requête mère pour effectuer le traitement
        $form->handleRequest($this->get('request_stack')->getMasterRequest());

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->render('blog/_commentForm.html.twig', [
            'commentForm' => $form->createView()
        ]);
    }



    /**
     * @Route("/notFound", name="blog_not_found")
     */
    public function notFound(){
        return $this->render('blog/notFound.html.twig');
    }

    /**
     * @Route("/exemple_admin", name="blog_admin")
     */
    public function admin(){
        //exemple de refus a un utilisateur non admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');


    }
}
