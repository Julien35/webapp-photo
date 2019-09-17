<?php

namespace App\Controller;

use App\Manager\CartManager;
use App\Service\BrainTreeCheckout;
use App\Service\MailService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    /**
     * @var BrainTreeCheckout $brainTreeCheckout
     */
    private $brainTreeCheckout;

    /**
     * @var MailService $mailService
     */
    private $mailService;

    /** @var CartManager $cartManager
     *
     */
    private $cartManager;

    public function __construct(
        BrainTreeCheckout $brainTreeCheckout,
        CartManager $cartManager,
        MailService $mailService
    )
    {
        $this->brainTreeCheckout = $brainTreeCheckout;
        $this->mailService = $mailService;
        $this->cartManager = $cartManager;
    }

    /**
     * @Route("api/checkout/client-token", name="client_token", methods="GET")
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
     * @Route("api/checkout/transaction", name="transaction", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function transaction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $transaction = $this->brainTreeCheckout->createTransaction($data['amount'], $data['nonce']);

        try {
            if ($transaction->success) {
                $totalPrice = $data['amount'];

                $cart = $this->cartManager->getCart($data['cartId']);
                $cart->setPrixTotalTtc($totalPrice);
                $cart->setprixTotalHt($totalPrice - $totalPrice * 0.20);
                $cart->setPaid(true);
                $updateCart = $this->cartManager->update($cart);

                $isSent = $this
                    ->mailService
                    ->sendCheckoutMail($updateCart);
            }
        } catch (Exception $e) {

        }

        return $this->json(
            $transaction
        );
    }

}
