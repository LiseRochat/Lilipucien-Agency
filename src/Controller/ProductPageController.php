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
        // On recupère tous les biens catégorie biens populaire
        $biens = $doctrine->getRepository(Bien::class)->findAll();
        // Récupère l'objet en fonction de l'@Id (généralement appelé $id)
        $bien = $doctrine->getRepository(Bien::class)->find($id);
        // vérifier $bien avec le var dump => if($bien){var dump}else{erreur}
        return $this->render('product_page/details.html.twig', [
            'bien' => $bien,
            'biens' => $biens
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

        return $this->render('product_page/form-add.html.twig',[
            "form_title" => "Ajouter un bien",
            'formBien' => $formBien->createView()
        ]);
        // return $this->renderForm('bien/form-add.html.twig', ['formBien' => $formBien]);
    }

    #[Route('/bien/edit/{id}', name: 'edit_product')]
    public function modifyProduct(Request $request, int $id): Response
    {
        
    
        // Etape 1 : on recupère le bien a modifier
        $bien = $entityManager->getRepository(Bien::class)->find($id);
        $bien->setUpdatedAt(new DateTimeImmutable()); //donne la date du jour

        // Etape 2 : on créer le formulaire 
        $formBien = $this->createForm(BienType::class, $bien);

        $formBien->handleRequest($request);
        if($formBien->isSubmitted() && $formBien->isValid())
        {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // Ajouter un message pour le feedback, dans la variable de session 'flash'
            $this->addFlash('success_add', 'Le bien '.$bien->getTitre(). ' a bien été modifié !');

            return $this->redirectToRoute('app_home');
        }
    
        return $this->render("product_page/form-add.html.twig", [
            "form_title" => "Modifier un bien",
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