<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\Registration;
use App\Manager\CartManager;
use App\Manager\RegistrationManager;
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

    /**
     * @var RegistrationManager $registrationManager
     */
    private $registrationManager;


    public function __construct(PhotoUploadService $photoUploadService, CartManager $cartManager, RegistrationManager $registrationManager)
    {
        $this->photoUploadService = $photoUploadService;
        $this->cartManager = $cartManager;
        $this->registrationManager = $registrationManager;
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
        $registrationData = $request->request->get('registration');

        if (!is_null($photosFiles) && !is_null($photosData) && !is_null($registrationData)) {

            $conn = $this->getDoctrine()->getConnection();
            $conn->beginTransaction();

            try {
                /** Cart $cart */
                $cart = $this->cartManager->initCart();
                // Create Product with cart_id
                $products = $this->photoUploadService->uploadPhotos($photosData, $photosFiles);
                // update Cart with register_id
                $registration = $this->registrationManager->initRegistration(json_decode($registrationData[0]));

                // Update Cart with all value
                $updateCart = $this->cartManager->update($cart, $products, $registration);

                $conn->commit();
                $status = ['status' => "success", "fileUploaded" => true];
            } catch (ORMException $e) {
                $conn->rollback();
            }

        }

        return $this->json($status);
    }

}
