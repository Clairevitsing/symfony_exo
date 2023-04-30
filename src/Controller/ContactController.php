<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_list')]
    public function index(
        Request $request,
        // ContactRepository $contactRepository
        EntityManagerInterface $manager,
        MailerInterface $mailer
    ): Response {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('admin@hb.com')
            ->subject($contact->getSubject())
            ->htmlTemplate('emails/contact.html.twig')
            ->context(['contact' => $contact]);

        $mailer->send($email);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash(
                'success',
                'your request has been submitted'
            );
            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
