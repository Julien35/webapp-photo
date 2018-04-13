<?php

namespace App\Manager;

use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\RegistrationRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class CartManager
{
//    private $cartRepository;
//    private $productRepository;
//    private $registrationRepository;

    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository, RegistrationRepository $registrationRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Create a new Cart with no product & registration link
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function initCart()
    {
        $cart = new Cart();
        $cart->setDateCreation(new DateTime());
        $cart->setprixTotalHt(0);
        $cart->setPrixTotalTtc(0);
        $cart->setCheckout(false);
        $cart->setPaid(false);

        $this->cartRepository->save($cart);
        return $cart;
    }

    /**
     * @param Cart $cart
     * @param array $products
     * @return Cart
     * @throws \Doctrine\ORM\ORMException
     */
    public function update(Cart $cart, array $products) : Cart
    {
        foreach ($products as $product) {
            $cart->addProduct($product);
        }
        $this->cartRepository->save($cart);
        return $cart;
    }

}
