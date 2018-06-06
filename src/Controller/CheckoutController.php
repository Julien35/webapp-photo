<?php

namespace App\Controller;

use App\Manager\CartManager;
use App\Service\BrainTreeCheckout;
use App\Service\MailService;
use Doctrine\ORM\ORMException;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends Controller
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
    ) {
        $this->brainTreeCheckout = $brainTreeCheckout;
        $this->mailService = $mailService;
        $this->cartManager = $cartManager;
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
     * @param Swift_Mailer $mailer
     * @return JsonResponse
     */
    public function transaction(Request $request, Swift_Mailer $mailer)
    {
        $data = json_decode($request->getContent(), true);

        $transaction = $this->brainTreeCheckout->createTransaction($data['amount'], $data['nonce']);

        try {
            if ($transaction->success) {
                $cart = $this->cartManager->getCart($data['cartId']);
                $cart->setCheckout(true);
                $updateCart = $this->cartManager->update($cart);

                $isSent = $this
                    ->mailService
                    ->sendCheckoutMail($updateCart, $mailer);
            }
        } catch (Exception $e) {

        }

        return $this->json(
            $transaction
        );
    }

}
