<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Entity\Tasks;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gprojets');
    }

    public function configureMenuItems(): iterable
    {
        #yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        if ($this->isGranted("ROLE_ADMIN")) {
            yield MenuItem::linkToCrud('Users', 'fas fa-list', Users::class);
            yield MenuItem::linkToCrud('projects', 'fas fa-list', Project::class);
            yield MenuItem::linkToCrud('tasks', 'fas fa-list', Tasks::class);
        }
    }
}
