<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/")
     */
    public function home()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/api/photo/upload")
     * @return JsonResponse
     */
    public function upload()
    {
        return $this->json('Hello photo');
    }
}
