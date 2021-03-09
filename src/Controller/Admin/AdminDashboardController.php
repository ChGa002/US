<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Module;
use App\Entity\MotCle;
use App\Entity\Semestre;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class AdminDashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="us_admin_dash")
     */
    public function index(): Response 
    {
        //return parent::index();
        // // redirect to some CRUD controller
         $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UtilisateurCrudController::class)->generateUrl());

        // // you can also redirect to different pages depending on the current user
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // // you can also render some template to display a proper Dashboard
        // // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        // return $this->render('some/path/my-dashboard.html.twig');
        
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('US - University Share');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', Utilisateur::class),

            MenuItem::section('Publications'),
            MenuItem::linkToCrud('Posts', 'fa fa-file', Post::class),
            MenuItem::linkToCrud('Mots-Clés','fa fa-list',MotCle::class),

            MenuItem::section('Repertoires'),
            MenuItem::linkToCrud('Modules', 'fa fa-folder', Module::class),
            MenuItem::linkToCrud('Semestres', 'fa fa-folder', Semestre::class),
        ];
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }
}
