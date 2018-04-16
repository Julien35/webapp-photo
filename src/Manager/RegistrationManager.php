<?php

namespace App\Manager;

use App\Entity\Registration;
use App\Repository\RegistrationRepository;

class RegistrationManager
{
    public function __construct(RegistrationRepository $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }


    public function initRegistration(array $data = null)
    {
        $registration = new Registration();

        return $registration;
    }

}
