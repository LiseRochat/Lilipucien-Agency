<?php

namespace App\Controller;
use App\Entity\Contact;
use App\Form\ContactType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer): Response
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

            // Envoi3.2: On envoi l'email
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('contact@live.fr')
                ->subject('Formulaire de Contact')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'contact' => $contact
                ]);
            $mailer->send($email);

            $this->addFlash('succes_mail', 'Le mail a bien été envoyé !');
        }

        return $this->render('contact/index.html.twig', [
            "form_submit" => "Envoyer",
            'formContact'=> $formContact->createView(),
        ]);
    }
}
