<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Module;
use App\Entity\Semestre;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class AdminDashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="us_admin_dash")
     */
    public function index(): Response
    {
        $userList = $this->get(CrudUrlGenerator::class)->build()->setController(UtilisateurCrud::class)->generateUrl();

        return $this->redirect($userList);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('US');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Utilisateurs'),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', Utilisateur::class),

            MenuItem::section('Posts'),
            MenuItem::linkToCrud('Posts', 'fa fa-file', Post::class),

            MenuItem::section('Modules'),
            MenuItem::linkToCrud('Modules', 'fa fa-folder', Module::class),

            MenuItem::section('Semèstres'),
            MenuItem::linkToCrud('Semèstres', 'fa fa-folder', Semestre::class),
        ];
    }
}
