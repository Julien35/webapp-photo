<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("api/image/upload", name="image-upload")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function upload(Request $request)
    {

        $data = json_decode($request->getContent(), true);

        $files = $request->files->get('files');
        $status = array('status' => "success", "fileUploaded" => false);

        $file = $files[0];

//        if ($file instanceof UploadedFile && !is_null($file)) {

        // create Form
        $product = new Product();
//        $product->setImageFile($file);
//        $product->setImageName($file->getClientOriginalName());
//        $product->setForm($file->getClientOriginalName());

        $form = $this->createFormBuilder($product)
//            ->add('imageFile', FileType::class)
//            ->add('imageName', TextType::class)
//            ->add('format', TextType::class)
//            ->add('finition', TextType::class)
//            ->add('submit', SubmitType::class)
            ->getForm();

//        $form->

//        $form->handleRequest($request);
        $form->submit($data);

//            if submit & valid => store information to bdd, image is copied by vichuploader
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

//                return new Response('<html><body>Upload ok</body></html>');
            $status = array('status' => "success", "fileUploaded" => true);
        }

//        }

//        return $this->render('test-form.html.twig',
//            ['form' => $form->createView()]);

        return new JsonResponse($status);
    }

}

