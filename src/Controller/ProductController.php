<?php

namespace App\Controller;
use DateTimeImmutable;
use App\Entity\Products;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    /**
     * Methode permettant l'affichage du produit en fonction de son id 
     */
    #[Route('/produits/details/{id}', name: 'app_product')]
    public function index(int $id, ManagerRegistry $doctrine): Response
    {
        // On recupère tous les produits
        $products = $doctrine->getRepository(Products::class)->findAll();
        // On recupère le produit sélectionné
        $product = $doctrine->getRepository(Products::class)->find($id);
        return $this->render('product/show.html.twig', [
            'products' => $products,
            'product' => $product,
        ]);
    }

    /**
     * Methode permettant l'ajout d'un nouveau produit
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/produits/ajouter', name: 'app_product_add')]
    public function productAdd(Request $request, ManagerRegistry $doctrine)
    {
        // On instancie notre objet produit
        $product = new Products();

        // On initialise nos champs dates avec la date d'aujourd'hui
        $product->setCreatedAt(new DateTimeImmutable('now'));

        // Etape 01 : Crée une instance de la classe Form à partir de la classe Products
        $formProduct = $this->createForm(ProductType::class, $product);
        // Etape 02 : Permet de gérer le traitement de la saisie du formulaire.
        $formProduct->handleRequest($request);

        // Etape 03 : test si le formulaire a été saisi et si les règles de validations sont vérifiées
        if($formProduct->isSubmitted() && $formProduct->isValid())
        {
            $entityManager = $doctrine->getManager();
            // Etape 3.1 : On demande à doctrine de surveiller / gerer l'objet en cours
            $entityManager->persist($product);
            // Etape 3.2 : On envoi les données a la bdd
            $entityManager->flush();
            // Etape 3.3 : Affichage d'un message succès
            $this->addFlash('success_product', 'Le produit '. $product->getTitle(). ' a été ajouté !');
            // Etape 3.4 : redirection
            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('product/form-product.html.twig', [
            'form_title' => 'Ajouter un produit',
            'form_submit' => 'Ajoutez',
            'formProduct' => $formProduct->createView()
        ]);
    }

    /**
     * Methode permettant la modification d'un produit
     */
    #[Route('/produits/modifier/{id}', name: 'app_product_edit')]
    public function productEdit(int $id, Request $request, ManagerRegistry $doctrine): Response
    {
        // Etape 01 : On récupère notre objet
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Products::class)->find($id);

        if(!$product)
        {
            $this->addFlash('error_product', 'Le produit n\'existe pas !');
        }

        $product->setUpdatedAt(new DateTimeImmutable());

        $formProduct = $this->createForm(ProductType::class, $product);

        // Etape 02 : Permet de gérer le traitement de la saisie du formulaire. Pour modifier l'objet.
        $formProduct->handleRequest($request);

        if($formProduct->isSubmitted() && $formProduct->isValid())
        {
            // Etape 03 : On apelle la methode flush
            $entityManager->flush();

            $this->addFlash('success_product', 'Le produit '.$product->getTitle(). ' a bien été modifié !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('product/form-product.html.twig', [
            'form_title' => 'Modifier un produit',
            'form_submit' => 'Modifier',
            'formProduct' => $formProduct->createView(),
        ]);
    }

    /**
     * Methode permettant la supression d'un produit
     */
    #[Route('/product/suprimer/{id}', name: 'app_product_delete')]
    public function productDelete(int $id, ManagerRegistry $doctrine): Response
    {
        // Etape 01 : On recupère l'objet à supprimer
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Products::class)->find($id);

        if(!$product)
        {
            $this->addFlash('error_product', 'Le produit n\'existe pas !');
        }

        // Etape 02 : On fait appel a la methode remove du service entityManager
        $entityManager->remove($product);
        // Etape 03 : Methode flush()
        $entityManager->flush();

        $this->addFlash('success_product', 'Le bien '.$product->getTitle(). ' a bien été supprimez !');
        return $this->redirectToRoute('app_home');
    }

}
