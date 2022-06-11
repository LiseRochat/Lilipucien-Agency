<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\StatusType;
use App\Repository\StatusRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/status')]
class StatusController extends AbstractController
{
    #[Route('/statu', name: 'app_status_index', methods: ['GET'])]
    public function index(StatusRepository $statusRepository): Response
    {
        return $this->render('status/index.html.twig', [
            'statuses' => $statusRepository->findAll(),
        ]);
    }

    #[Route('/statu/ajouter', name: 'app_status_new', methods: ['GET', 'POST'])]
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

    #[Route('/statu/details/{id}', name: 'app_status_show', methods: ['GET'])]
    public function show(Status $status): Response
    {
        
        return $this->render('status/show.html.twig', [
            'status' => $status,
        ]);
    }

    #[Route('/statu//modifier/{id}', name: 'app_status_edit', methods: ['GET', 'POST'])]
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

    #[Route('/statu/supprimer/{id}', name: 'app_status_delete')]
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
