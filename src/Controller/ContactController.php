<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Route("/api/contact", name="contact")
     */
    public function contact()
    {
        return $this->json('contact ok');
    }
}
