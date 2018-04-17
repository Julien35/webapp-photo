<?php

namespace App\Manager;

use App\Entity\Registration;
use App\Repository\RegistrationRepository;
use DateTime;

class RegistrationManager
{
    public function __construct(RegistrationRepository $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }


    /**
     * @param null $data
     * @return Registration
     * @throws \Doctrine\ORM\ORMException
     */
    public function initRegistration($data = null)
    {
        $registration = new Registration();
        $registration->setName($data->name);
        $registration->setFirstname($data->firstname);
        $registration->setAddress1($data->address1);
        $registration->setAddress2($data->address2);
        $registration->setPostal($data->postal);
        $registration->setCity($data->city);
        $registration->setCountry($data->country);
        $registration->setPhone($data->phone);
        $registration->setEmail($data->email);
        $registration->setDatetime(new DateTime());

        $this->registrationRepository->save($registration);

        return $registration;
    }

}
