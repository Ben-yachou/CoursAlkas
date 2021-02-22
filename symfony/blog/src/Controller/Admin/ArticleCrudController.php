<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    //cette méthode renvoie le nom de la classe dont le controller doit s'occuper
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    //configureFields permet de choisir quels sont les champs à afficher et dans quelles circonstances (si on les affiche seulement sur la liste d'entités, on peut par exemple utiliser hideOnForm pour ne pas les voir dans un formulaire d'édition ou de création)
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('content'),
            DateField::new('createdAt')->hideOnForm(),
            //AssociationField permet d'afficher des données qui sont des relations entre entités
            AssociationField::new('author')
        ];
    }

    //si on surcharge une méthode comme createEntity cela nous permet de rajouter du code personnalisé lors de la création d'une entité
    public function createEntity(string $entityFqcn)
    {
        $article = new Article();
        //ici cela est nécessaire pour pouvoir préciser une date de création auto-générée
        $article->setCreatedAt(new \DateTime());
        //ainsi que pour récupérer notre utilisateur
        $article->setAuthor($this->getUser());

        return $article;
    }
}
