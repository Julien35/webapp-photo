<?php

namespace App\Controller;

use App\Service\BrainTreeCheckout;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends Controller
{
    private $brainTreeCheckout;

    public function __construct(BrainTreeCheckout $brainTreeCheckout)
    {
        $this->brainTreeCheckout = $brainTreeCheckout;
    }

    /**
     * @Route("api/checkout", name="transaction")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function transaction()
    {
        $result = $this->brainTreeCheckout->createTransaction(10);
        return $this->json($result);
    }
}