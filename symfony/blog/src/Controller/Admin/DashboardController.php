<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    //Un dashboard/tableau de bord dans easy admin est une interface permettant d'accéder à des actions CRUD sur nos entités
    //DashboardController nous permet de personnaliser un panneau de contrôle pour notre interface d'administration

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //par défaut du code est généré comme celui ci qui affiche un index par défaut contenant des instructions sur le paramétrage d'easyAdmin
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        //cette méthode configureDashBoard permet de définir certaines options comme le titre, le style du panneau de contrôle, si on veut une icone particulière ou pas, insérer un logo, etc
        return Dashboard::new()
            ->setTitle('Blog Admin');
    }

    public function configureMenuItems(): iterable
    {
        //cette méthode configureMenuItems permet de choisir quels sont les éléments qui s'affichent dans le menu de notre page admin
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            //ici par exemple linkToCrud nous permet d'envoyer vers un controller se chargeant des opérations crud sur une entité particulière
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Articles', 'fa fa-pen', Article::class),
        ];
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
