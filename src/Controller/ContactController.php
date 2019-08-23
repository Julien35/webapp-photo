<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Manager\ContactManager;
use App\Service\MailService;
use Doctrine\ORM\ORMException;
use Exception;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @var ContactManager $contactManager
     */
    private $contactManager;

    /**
     * @var MailService $mailService
     */
    private $mailService;

    public function __construct(ContactManager $contactManager, MailService $mailService)
    {
        $this->contactManager = $contactManager;
        $this->mailService = $mailService;
    }


    /**
     * @Route("/new", name="contact_new", methods="POST")
     * @param Request $request
     * @param Swift_Mailer $mailer
     * @return Response
     */
    public function new(Request $request, Swift_Mailer $mailer): Response
    {
        $data = json_decode($request->getContent(), true);

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->submit($data);

        try {
            $this->contactManager->save($contact);
            $this->mailService->sendContactMail($contact, $mailer);

            return $this->json(true, 201);
        } catch (Exception $e) {
            return $this->json(false, 503);
        }
    }

}
