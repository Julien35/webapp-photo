<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ImageProduct;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        // retrieve the file with the name given in the form.
        // do var_dump($request->files->all()); if you need to know if the file is being uploaded.
        $file = $request->files->get('file');
        $status = array('status' => "success", "fileUploaded" => false);

        // If a file was uploaded
        if (!is_null($file)) {
            // generate a random name for the file but keep the extension
            $filename = uniqid() . "." . $file->getClientOriginalExtension();
            $path = "images/products";
            $file->move($path, $filename); // move the file to a path
            $status = array('status' => "success", "fileUploaded" => true);
        }

        return new JsonResponse($status);
    }

}
