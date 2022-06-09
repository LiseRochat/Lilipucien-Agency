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
        $biens = $doctrine->getRepository(Bien::class)->findBy([], ['id' => 'DESC']);
        return $this->render('home/index.html.twig', [
            'biens' => $biens 
        ]);
    }

    #[Route('/rental', name: 'rental')]
    public function rental(ManagerRegistry $doctrine): Response
    {
        $biens = $doctrine->getRepository(Bien::class)->findBy(['status' => 1]);
        return $this->render('home/rental.html.twig', [
            'biens' => $biens 
        ]);
    }

    #[Route('/sale', name: 'sale')]
    public function sale(ManagerRegistry $doctrine): Response
    { 
        $biens = $doctrine->getRepository(Bien::class)->findBy(['status' => 2]);
        return $this->render('home/sale.html.twig', [
            'biens' => $biens 
        ]);
    }

    #[Route('/holiday', name: 'holiday')]
    public function holiday(ManagerRegistry $doctrine): Response
    {
        $biens = $doctrine->getRepository(Bien::class)->findBy(['status' => 3]);
        return $this->render('home/holiday.html.twig', [
            'biens' => $biens 
        ]);
    }
}