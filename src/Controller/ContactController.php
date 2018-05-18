<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Manager\ContactManager;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/contact")
 */
class ContactController extends Controller
{

    /**
     * @var ContactManager $contactManager
     */
    private $contactManager;

    public function __construct(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;
    }


    /**
     * @Route("/new", name="contact_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->submit($data);

        try {
            $this->contactManager->save($contact);
            return $this->json(true, 201);
        } catch (ORMException $e) {
            return $this->json(false, 503);
        }
    }

}
