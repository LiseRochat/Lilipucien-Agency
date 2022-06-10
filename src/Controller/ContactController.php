<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        // Etape 01 : On ccrée le formulaire
        $contact = new Contact();
        $contact->setSentAt(new \DateTimeImmutable('now'));

        // Etape02 : On crée le formulaire
        $formContact = $this->createForm(ContactType::class, $contact);
        return $this->render('contact/index.html.twig', [
            'formContact'=> $formContact->createView(),
        ]);
    }
}
