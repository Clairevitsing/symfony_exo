<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Contact\ContactNotifier;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_list', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(
        Request $request,
        ContactNotifier $contactNotifier,
        EntityManagerInterface $manager,
        MailerInterface $mailer
    ): Response {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $contactNotifier->send($contact); {

                $this->addFlash(
                    'success',
                    'your request has been submitted'
                );
            }

            // $contact = $form->getData();
            // $manager->persist($contact);
            // $manager->flush();

            // $email = (new TemplatedEmail())
            //     ->from($contact->getEmail())
            //     ->to('admin@hb.com')
            //     ->subject($contact->getSubject())
            //     ->htmlTemplate('emails/contact.html.twig')
            //     ->context(['contact' => $contact]);

            // $mailer->send($email);

            // $this->addFlash(
            //     'success',
            //     'your request has been submitted'
            // );
            // return $this->redirectToRoute('contact_list');
        }

        // return $this->render('contact/index.html.twig', [                  
        //     'form' => $form->createView(),
        // ]);

        return $this->renderForm('contact/index.html.twig', [
            'form' => $form
        ]);
    }
}
