<?php

namespace App\Manager;


use App\Entity\Contact;
use App\Repository\ContactRepository;

class ContactManager
{
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->$contactRepository = $contactRepository;
    }

    /**
     * @param Contact $contact
     * @return Contact
     */
    public function save(Contact $contact)
    {
        return $contact;
//        return $this->contactRepository->save($contact);
    }
}