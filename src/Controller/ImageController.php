<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Manager\CartManager;
use App\Service\PhotoUploadService;
use DateTime;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImageController extends Controller
{
    /**
     * @var PhotoUploadService $photosUploadService
     */
    private $photoUploadService;

    /**
     * @var CartManager $cartManager
     */
    private $cartManager;

    public function __construct(PhotoUploadService $photoUploadService, CartManager $cartManager)
    {
        $this->photoUploadService = $photoUploadService;
        $this->cartManager = $cartManager;
    }


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
        $status = ['status' => "success", "fileUploaded" => false];
        // Array of Uploadedfile
        $photosFiles = $request->files->get('photosFiles');
        $photosData = $request->request->get('photosData');
        $registration = $request->request->get('registration');

        if (!is_null($photosFiles) && !is_null($photosData) && !is_null($registration)) {

            try {
                /** Cart $cart */
                $cart = $this->cartManager->initCart();// Create Product with cart_id
                $products = $this->photoUploadService->uploadPhotos($photosData, $photosFiles);
                $updateCart = $this->cartManager->update($cart, $products, $registration);

                $status = ['status' => "success", "fileUploaded" => true];
            } catch (ORMException $e) {

            }

        }


//        create Register return id
//        update Cart with register_id

        return $this->json($status);
    }

}

