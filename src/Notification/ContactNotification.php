<?php

namespace App\Notification;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class ContactNotification
{

    /**
     * @var \MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify(Contact $contact)
    {
        $email = (new TemplatedEmail())
        ->from('test@test.fr')
        ->to('test@test.fr')
        ->subject('Nouveau message !')
        ->text("Nouvelle demande de la part de" . $contact->getPrenom())
        ->htmlTemplate('Contact/contact.html.twig')
        ->context([
         'contact' => $contact
        ]);


    $this->mailer->send($email);
    }
}
