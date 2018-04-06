<?php

namespace App\Service;

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
     * @param UploadedFile $file
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     */
    public function uploadFile($file, $data)
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

    }
}