<?php

namespace App\Controller;
use App\Entity\Status;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavController extends AbstractController
{
    #[Route('/nav', name: 'app_nav')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $statuses = $doctrine->getRepository(Status::class)->findAll();
        return $this->render('includes/_navbar.html.twig', [
            'statuses' => $statuses,
        ]);
    }
}
