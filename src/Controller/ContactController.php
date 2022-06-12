<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);

        if($formContact->isSubmitted() && $formContact->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            
            $this->addFlash('success_contact', 'Votre message à bien été envoyé.');

            return $this->redirectToRoute('app_home');

        }
        
        return $this->render('contact/index.html.twig', [
            'form_title' => 'Formulaire de Contact',
            'form_submit' => 'Envoyer',
            'formContact' => $formContact->createView(),
        ]);
    }
}
