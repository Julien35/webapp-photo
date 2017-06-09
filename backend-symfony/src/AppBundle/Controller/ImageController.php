<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ImageProduct;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    /**
     * @Route("/image/upload", name="image_by_slug")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function uploadAction(Request $request)
    {
        $image = new ImageProduct();

        $test = $request;
        return new JsonResponse(['upload image', $test]);
    }

}