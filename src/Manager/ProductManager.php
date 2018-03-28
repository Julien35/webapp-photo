<?php

namespace App\Manager;

use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductManager
{
    /**
     * @var ProductRepository $productRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Product $product
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Product $product)
    {
        $this->productRepository->save($product);
    }
}
