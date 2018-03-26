<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

class ImageController extends Controller
{
    /**
     * @Route("/api/photo/upload")
     * @return JsonResponse
     */
    public function uploadTest()
    {
        return $this->json('Hello photo');
    }


    /**
     * @Route("api/image/upload", name="image-by-slug")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function upload(Request $request)
    {
        $file= $request->files->get('file');
        $status = array('status' => "success", "fileUploaded" => false);

        if ($file instanceof UploadedFile && !is_null($file)) {
            // generate a random name for the file but keep the extension
//            $filename = uniqid() . "." . $file->getClientOriginalExtension();
//            $path = "images/products";
//            $file->move($path, $filename); // move the file to a path
//            $status = array('status' => "success", "fileUploaded" => true);

            // use of vich bundle
            $product = new Product();

            $formFactory = Forms::createFormFactoryBuilder()
                ->addExtension(new HttpFoundationExtension())
                ->getFormFactory();

            $form = $formFactory->createBuilder()
                ->add('title', 'text')
                ->add('imageFile', 'file')
                ->add('save', 'submit')
                ->getForm();

            $form->handleRequest($request);

            if ($form->isValid()) {
                // On l'enregistre notre objet $advert dans la base de données, par exemple
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();
            }

        }

        return new JsonResponse($status);
    }

}

