<?php

namespace App\Manager;


use App\Entity\Contact;
use App\Repository\ContactRepository;

class ContactManager
{
    /**
     * @var ContactRepository $contactRepository
     */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param Contact $contact
     * @return Contact
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Contact $contact)
    {
        $this->contactRepository->save($contact);
        return $contact;
    }
}
