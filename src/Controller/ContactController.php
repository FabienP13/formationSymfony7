<?php

namespace App\Controller;

use App\DTO\ContactFormDTO;
use App\Event\ContactRequestEvent;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index')]
    public function contact(Request $request, MailerInterface $mailer, EventDispatcherInterface $distpatcher): Response
    {
        $contactDTO = new ContactFormDTO;
        $form = $this->createForm(ContactType::class, $contactDTO);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                $distpatcher->dispatch(new ContactRequestEvent($contactDTO));
                $this->addFlash('success', 'Votre message a été envoyé avec succès !');
                return $this->redirectToRoute('contact.index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Impossible d\'envoyer votre mail ');
            }
            // try {
            //     $email = (new TemplatedEmail())
            //         ->from($contactDTO->getEmail())
            //         ->to($contactDTO->getService()) // Remplacez par votre email
            //         ->subject('Demande de contact')
            //         ->htmlTemplate('emails/contact.html.twig')
            //         ->context(['data' => $contactDTO]);

            //     $mailer->send($email);

            // } catch (\Exception $e) {
            //     
            // }
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
