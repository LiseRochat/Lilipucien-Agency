<?php

namespace App\Controller;

use App\Entity\Status;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatusController extends AbstractController
{
    #[Route('/status', name: 'app_status')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $status =  $doctrine->getRepository(Status::class)->findAll();
        return $this->render('status/status.html.twig', [
            'status' => $status
        ]);
    }

    #[Route('/status/add', name: 'app_status_add')]
    public function add()
    {

    }

    #[Route('/status/edit/{id}', name: 'app_status_edit')]
    public function edit()
    {
        
    }

    #[Route('/status/delete/{id}', name: 'app_status_delete')]
    public function delete()
    {
        
    }

}
