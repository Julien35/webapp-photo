<?php

namespace App\Manager;

use App\Entity\Cart;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\RegistrationRepository;

class CartManager
{
    /**
     * @var CartRepository $cartRepository
     */
    private $cartRepository;

    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository, RegistrationRepository $registrationRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->registrationRepository = $registrationRepository;
    }

    /**
     */
    public function all()
    {
        $cart = $this->cartRepository->findAll();
        $product = $this->productRepository->findAll();
        $registration = $this->registrationRepository->findAll();

        return [
            'cart' => $cart,
            'product' => $product,
            'registration' => $registration
        ];
    }
}
