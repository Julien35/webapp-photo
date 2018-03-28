<?php

namespace App\Controller;

use App\Service\PhotoUploadService;
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

    public function __construct(PhotoUploadService $photoUploadService)
    {
        $this->photoUploadService = $photoUploadService;
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
        $status = array('status' => "success", "fileUploaded" => false);

        /** @var array<UploadedFile> $photosFiles */
        $photosFiles = $request->files->get('photosFiles');
        $photosData = $request->request->get('photosData');

        foreach ($photosFiles as $key => $file) {
            $data = json_decode($photosData[$key]);

            if ($file instanceof UploadedFile && !is_null($file) && !is_null($data)) {
                $this->photoUploadService->uploadFile($file, $data);

                $status = array('status' => "success", "fileUploaded" => true);
            }
        }

        return new JsonResponse($status);
    }

}

