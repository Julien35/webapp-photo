<?php

namespace App\Manager;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\Registration;
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
     * @param int $id
     * @return Cart
     */
    public function getCart($id): Cart
    {
        return $this->cartRepository->find($id);
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
        $cart->setPaid(false);
        $cart->setPrinted(false);

        $this->cartRepository->save($cart);
        return $cart;
    }

    /**
     * @param Cart $cart
     * @param array|null $products
     * @param Registration|null $registration
     * @return Cart
     * @throws \Doctrine\ORM\ORMException
     */
    public function update(Cart $cart, array $products = null, Registration $registration = null) : Cart
    {
        $totalPrice = 0;
        // todo: calcul priceItem with support, format, finition of one product
        $priceItem = 1.99;

        if (isset($registration)) {
            $cart->setRegistration($registration);
        }

        if (isset($products)) {
            /** @var  Product $product */
            foreach ($products as $product) {
                $cart->addProduct($product);
                $totalPrice += $product->getQuantity() * $priceItem;
            }

            $cart->setPrixTotalTtc($totalPrice);
            $cart->setprixTotalHt($totalPrice - $totalPrice * 0.20);
        }

        $this->cartRepository->save($cart);
        return $cart;
    }

}
