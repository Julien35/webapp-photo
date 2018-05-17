<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Route("/api/contact", name="contact")
     */
    public function contact(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        return $this->json('contact ok');
    }
}
