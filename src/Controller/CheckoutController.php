<?php

namespace App\Controller;

use App\Service\BrainTreeCheckout;
use Exception;
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
     * @Route("api/checkout/client-token", name="client_token")
     * @Method({"GET"})
     *
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getToken()
    {
        try {
            $token = $this->brainTreeCheckout->getClientToken();
        } catch (Exception $e) {
            $token = $e;
        }

        return $this->json($token);
    }

    /**
     * @Route("api/checkout/transaction", name="transaction")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function transaction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        return $this->json([
            'status' => $this->brainTreeCheckout->createTransaction($data['amount'], $data['nonce'])
        ]);
    }
}