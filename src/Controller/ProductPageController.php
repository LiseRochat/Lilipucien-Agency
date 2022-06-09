<?php

namespace App\Controller;
use App\Entity\Bien;
use App\Form\BienType;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductPageController extends AbstractController
{
    #[Route('/bien/details/{id}', name: 'product')]
    public function details($id, ManagerRegistry $doctrine): Response
    {
        $biens = $doctrine->getRepository(Bien::class)->findAll();
        $bien = $doctrine->getRepository(Bien::class)->find($id);

        return $this->render('product_page/details.html.twig', [
            'bien' => $bien,
            'biens' => $biens
        ]);
    }

    #[Route('/bien/add', name: 'add_product')]
    public function add(Request $request, ManagerRegistry $doctrine)
    {
 
        $bien = new Bien();
        
        $bien->setCreatedAt(new DateTimeImmutable()); 
        $bien->setUpdatedAt(new DateTimeImmutable()); 
        $formBien = $this->createForm(BienType::class, $bien);
        $formBien->handleRequest($request);

        if($formBien->isSubmitted() && $formBien->isValid()){

            $entityManager = $doctrine->getManager();
            $entityManager->persist($bien);
            $entityManager->flush();

            $this->addFlash('success_add', 'Le bien a été ajouté !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('product_page/form-add.html.twig',[
            "form_title" => "Ajouter un bien",
            "form_submit" => "Ajoutez",
            'formBien' => $formBien->createView()
        ]);
    }

    #[Route('/bien/edit/{id}', name: 'edit_product')]
    public function modifyProduct(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $bien = $entityManager->getRepository(Bien::class)->find($id);
        $bien->setUpdatedAt(new DateTimeImmutable()); //donne la date du jour

        $formBien = $this->createForm(BienType::class, $bien);

        $formBien->handleRequest($request);
        if($formBien->isSubmitted() && $formBien->isValid())
        {
            
            $entityManager->flush();

            $this->addFlash('success_add', 'Le bien '.$bien->getTitre(). ' a bien été modifié !');

            return $this->redirectToRoute('app_home');
        }
    
        return $this->render("product_page/form-add.html.twig", [
            "form_title" => "Modifier un bien",
            "form_submit" => "Modifier",
            "formBien" => $formBien->createView(),
        ]);
    }

    #[Route('/bien/delete/{id}', name: 'delete_product')]
    public function deleteProduct(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $bien = $entityManager->getRepository(Bien::class)->find($id);
        $entityManager->remove($bien);
        $entityManager->flush();

        $this->addFlash('success_add', 'Le bien '.$bien->getTitre(). ' a bien été supprimez !');
        return $this->redirectToRoute("app_home");
    }
}