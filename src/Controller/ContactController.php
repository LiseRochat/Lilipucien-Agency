<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManager $doctrine): Response
    {
        // Etape 01 : On ccrée le formulaire
        $contact = new Contact();
        $contact->setSentAt(new \DateTimeImmutable('now'));

        // Etape02 : On crée le formulaire
        $formContact = $this->createForm(ContactType::class, $contact);

        // Etape03 : On verifie si le formulaire a été soumis
        $formContact->handleRequest($request);
        if($formContact->isSubmitted() && $formContact->isValid()){

            // Etape3.1: On enregiste dans la BDD
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
        }
        return $this->render('contact/index.html.twig', [
            'formContact'=> $formContact->createView(),
        ]);
    }
}
