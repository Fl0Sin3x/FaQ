<?php
// src/Controller/Admin/DashboardController.php
namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Question;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{
    #isGranted('ROLE_ADMIN')
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SinexOverflow');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Question', 'fas fa-box', Question::class);
        yield MenuItem::linkToCrud('Réponse', 'fas fa-share', Answer::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tag', Tag::class);

    }
}
