<?php

namespace App\Controller;


use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestBddController extends Controller
{

    /** @var CartManager $cartManager */
    private $cartManager;

    public function __construct(CartManager $cartManager)
    {
        $this->cartManager = $cartManager;
    }

    /**
     * @Route("/test")
     */
    public function getAll()
    {
        $cart = $this->cartManager->all();
        return $this->render('test.html.twig', ['cart' => $cart]);
    }

}