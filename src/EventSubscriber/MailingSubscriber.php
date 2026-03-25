<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Event\ContactRequestEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class MailingSubscriber implements EventSubscriberInterface

{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function onLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();
        if(!$user instanceof User){
            return;
        }
        $email = (new Email())
                    ->from('support@demo.fr')
                    ->to($user->getEmail()) // Remplacez par votre email
                    ->subject('Connexion')
                    ->text('Vous vous êtes connecté à votre compte !');
                    -

                $this->mailer->send($email);

    }              
    public function onContactRequestEvent(ContactRequestEvent $event): void
    {
       
        $contactDTO = $event->getData();
        $email = (new TemplatedEmail())
                    ->from($contactDTO->getEmail())
                    ->to($contactDTO->getService()) // Remplacez par votre email
                    ->subject('Demande de contact')
                    ->htmlTemplate('emails/contact.html.twig')
                    ->context(['data' => $contactDTO]);

                $this->mailer->send($email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContactRequestEvent::class => 'onContactRequestEvent',
            InteractiveLoginEvent::class => 'onLogin',
        ];
    }
}
