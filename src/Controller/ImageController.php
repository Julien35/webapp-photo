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
        $status = array('status' => "success", "fileUploaded" => false);

        /** @var array<UploadedFile> $photosFiles */
        $photosFiles = $request->files->get('photosFiles');
        $photosData = $request->request->get('photosData');

        foreach ($photosFiles as $key => $file) {
            $data = json_decode($photosData[$key]);

            if ($file instanceof UploadedFile && !is_null($file) && !is_null($data)) {
                $this->uploadFile($file, $data);

                $status = array('status' => "success", "fileUploaded" => true);
            }
        }

        return new JsonResponse($status);
    }

    /**
     * @param UploadedFile $file
     * @param $data
     */
    private function uploadFile($file, $data)
    {
        $product = new Product();
        $product->setImageFile($file);
        $product->setImageName($data->nameText);
        $product->setImageSize($file->getSize());
        $product->setFormat($data->format);
        $product->setFinition($data->finition);

//            store information to bdd, image is copied by vichuploader
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
    }

}

