<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Products;
use App\Form\StatusType;
use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/status')]
class StatusController extends AbstractController
{
    /**
     * Methode permettant l'affichage de tous les status
     */
    #[Route('/', name: 'app_status_index')]
    public function index(StatusRepository $statusRepository, ManagerRegistry $doctrine): Response
    {
        $statuses = $statusRepository->findAll();
        return $this->render('status/index.html.twig', [
            'statuses' => $statuses,
        ]);
    }

    /**
     * Methode permettant l'affichage du detail du statu
     */
    #[Route('/details/{id}', name: 'app_status_show', methods: ['GET'])]
    public function show(Status $status): Response
    {
        return $this->render('status/show.html.twig', [
            'status' => $status,
        ]);
    }

    /**
     * Methode permettant l'affichage des produits en fonction de leurs status
     */
    #[Route('/produits/{id}', name: 'app_status_products', methods: ['GET'])]
    public function productByStatu(Status $status, int $id, ManagerRegistry $doctrine): Response
    {
        // Etape 01: On recupère les produits où le status_id est égale à l'identifiant du statu passé dans l'URL
        $products = $doctrine->getRepository(Products::class)->findBy( ['status' => $id],['id' => 'DESC']);

        return $this->render('status/show-by-status.html.twig', [
            'status' => $status,
            'products' => $products,
        ]);
    }

    /**
     * Methode permettant l'ajout d'un statu
     *
     * @param Request $request
     * @param StatusRepository $statusRepository
     * @return Response
     */
    #[Route('/ajouter', name: 'app_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StatusRepository $statusRepository): Response
    {
        $status = new Status();
        $formStatus = $this->createForm(StatusType::class, $status);
        $formStatus->handleRequest($request);

        if ($formStatus->isSubmitted() && $formStatus->isValid()) {
            $statusRepository->add($status, true);

            $this->addFlash('success_status', 'Le statu '.$status->getTitle().' à été ajouté !');

            return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status/new.html.twig', [
            'status' => $status,
            'formTitle' => 'Ajouter un statu',
            'formSubmit' => 'Ajouter',
            'formStatus' => $formStatus,
        ]);
    }

    /**
     * Methode permettant la modification d'un statu
     */
    #[Route('/modifier/{id}', name: 'app_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Status $status, StatusRepository $statusRepository): Response
    {
        $formStatus = $this->createForm(StatusType::class, $status);
        $formStatus->handleRequest($request);

        if ($formStatus->isSubmitted() && $formStatus->isValid()) {
            $statusRepository->add($status, true);

            $this->addFlash('success_status', 'Le statu '.$status->getTitle().' à été modifié !');

            return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status/edit.html.twig', [
            'status' => $status,
            'formTitle' => 'Modifier un statu',
            'formSubmit' => 'Modifier',
            'formStatus' => $formStatus,
        ]);
    }

    /**
     * Methode permettant la supression d'un statu
     */
    #[Route('/supprimer/{id}', name: 'app_status_delete')]
    public function delete(int $id, ManagerRegistry $doctrine): Response
    {
        // Etape 01 : On recupère l'objet à supprimer
        $entityManager = $doctrine->getManager();
        $status = $entityManager->getRepository(Status::class)->find($id);

        if(!$status)
        {
            $this->addFlash('error_status', 'Le status n\'existe pas !');
        }

        // Etape 02 : On fait appel a la methode remove du service entityManager
        $entityManager->remove($status);
        // Etape 03 : Methode flush()
        $entityManager->flush();

        $this->addFlash('success_status', 'Le statu '.$status->getTitle(). ' a bien été supprimez !');
        return $this->redirectToRoute('app_status_index');
    }
}
