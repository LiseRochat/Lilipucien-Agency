<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\StatusType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
    public function add(Request $request, ManagerRegistry $doctrine)
    {

        $status = new Status();
    
        $formStatus = $this->createForm(StatusType::class, $status);
        $formStatus->handleRequest($request);

        if($formStatus->isSubmitted() && $formStatus->isValid()){

            $entityManager = $doctrine->getManager();
            $entityManager->persist($status);
            $entityManager->flush();

            $this->addFlash('success_add', 'Le status a été ajouté !');

            return $this->redirectToRoute('app_status');
        }

        return $this->render('status/form-edit.html.twig',[
            "form_title" => "Ajouter un status",
            "form_submit" => "Ajoutez",
            'formStatus' => $formStatus->createView()
        ]);

    }

    #[Route('/status/edit/{id}', name: 'app_status_edit')]
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $status = $entityManager->getRepository(Status::class)->find($id);
         
        $formStatus = $this->createForm(StatusType::class, $status);

        $formStatus->handleRequest($request);
        if($formStatus->isSubmitted() && $formStatus->isValid())
        {
            $entityManager->flush();

            $this->addFlash('success_add', 'Le bien '.$status->getTitle(). ' a bien été modifié !');

            return $this->redirectToRoute('app_status');
        }
    
        return $this->render("status/form-edit.html.twig", [
            "form_title" => "Modifier un status",
            "form_submit" => "Modifier",
            "formStatus" => $formStatus->createView(),
        ]);
    }

    #[Route('/status/delete/{id}', name: 'app_status_delete')]
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $status = $entityManager->getRepository(Status::class)->find($id);
        $entityManager->remove($status);
        $entityManager->flush();

        $this->addFlash('success_add', 'Le status '.$status->getTitre(). ' a bien été supprimez !');
        return $this->redirectToRoute("app_status");
    }

}
