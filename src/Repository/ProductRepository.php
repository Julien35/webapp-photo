<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * @param Product $product
     */
    public function save(Product $product)
    {
        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
    }
}