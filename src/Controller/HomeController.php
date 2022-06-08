<?php

namespace App\Controller;

use App\Entity\Bien;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //$biens = $doctrine->getRepository(Biens::class)->findAll();
        $biens = $doctrine->getRepository(Bien::class)->findBy([], ['id' => 'DESC']);
        return $this->render('home/index.html.twig', [
            'biens' => $biens 
        ]);
    }
}