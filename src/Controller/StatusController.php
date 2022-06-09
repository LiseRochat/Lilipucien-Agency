<?php

namespace App\Controller;

use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController
{
    #[Route('/status', name: 'app_status')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $status = $doctrine->getRepository(Status::class)->findAll();
        return $this->render('status/status.html.twig', [
            'status' => $status
        ]);
    }
}
