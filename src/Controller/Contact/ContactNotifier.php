<?php

namespace App\Contact;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactNotifier
{
    public function __construct(
        private MailerInterface $mailer,
        private string $adminEmail
    ) {
    }

    public function send(Contact $data)
    {
        $email = new Email();
        $email
            ->from($data->getEmail())
            ->to($this->adminEmail)
            ->subject($data->getSubject())
            ->html('emails/contact.html.twig')
            ->text($data->getMessage());

        $this->mailer->send($email);
    }
}
