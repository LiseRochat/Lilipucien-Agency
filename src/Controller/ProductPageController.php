<?php

namespace App\Controller;

use DateTime;
use App\Entity\Bien;
use App\Form\BienType;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductPageController extends AbstractController
{
    #[Route('/bien/details/{id}', name: 'product')]
    public function details($id, ManagerRegistry $doctrine): Response
    {
        // Récupère l'objet en fonction de l'@Id (généralement appelé $id)
        $bien = $doctrine->getRepository(Bien::class)->find($id);
        // vérifier $bien avec le var dump => if($bien){var dump}else{erreur}
        return $this->render('product_page/details.html.twig', [
            'bien' => $bien
        ]);
    }

    #[Route('/bien/add', name: 'add_product')]
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        //etape 1 : à la création, on instancie une objet vide
        $bien = new Bien();
        //vous pouvez setter les valeurs par défaut de l'objet
        $bien->setCreatedAt(new DateTimeImmutable()); //donne la date du jour
        $bien->setUpdatedAt(new DateTimeImmutable()); //donne la date du jour

        // METHODE 1 : création du formulaire directement en controller
        // $formBien = $this->createFormBuilder($bien)
        // ->add('titre', TextType::class)
        // ->add('prix', IntegerType::class)
        // ->add('description', TextAreaType::class)
        // ->add('ville', TextType::class)
        // ->add('save', SubmitType::class, [
        //     'label' => 'Envoyer'
        // ])
        // ->getForm();

        //METHODE 02 : création formulaire avec le composant formType
        $formBien = $this->createForm(BienType::class, $bien);
        $formBien->handleRequest($request);

        if($formBien->isSubmitted() && $formBien->isValid()){

            $entityManager = $doctrine->getManager();
            $entityManager->persist($bien);
            $entityManager->flush();

            // Ajouter un message pour le feedback, dans la variable de session 'flash'
            $this->addFlash('success_add', 'Le bien a été ajouté !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('product_page/form-add.html.twig',['formBien' => $formBien->createView()]);
        // return $this->renderForm('bien/form-add.html.twig', ['formBien' => $formBien]);
    }

}