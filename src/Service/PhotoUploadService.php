<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\Product;
use App\Manager\ProductManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoUploadService
{
    /** @var ProductManager $productManager */
    private $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }


    /**
     * @param array $photosData
     * @param Cart $cart
     * @param array $photosFiles
     * @return Product[]|array
     * @throws \Doctrine\ORM\ORMException
     */
    public function uploadPhotos(array $photosData, array $photosFiles)
    {
        /** @var Product ...$products */
        $products = [];

        foreach ($photosFiles as $key => $file) {
            if ($file instanceof UploadedFile) {
                $data = json_decode($photosData[$key]);
                $products[] = $this->uploadPhoto($file, $data);
            }
        }
        return $products;
    }

    /**
     * @param UploadedFile $file
     * @param $data
     * @return Product
     * @throws \Doctrine\ORM\ORMException
     */
    public
    function uploadPhoto(UploadedFile $file, $data)
    {
        $product = new Product();
        $product->setImageFile($file);
        $product->setImageNameText($data->nameText);
        $product->setImageSize($file->getSize());
        $product->setFormat($data->format);
        $product->setFinition($data->finition);
        $product->setQuantity($data->quantity);

//            store information to bdd, image is copied by vichuploader
        $this->productManager->save($product);
        return $product;

    }
}
