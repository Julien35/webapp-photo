<?php

namespace App\Controller;

use App\Service\BrainTreeCheckout;
use App\Service\SendMailService;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends Controller
{
    private $brainTreeCheckout;

    private $sendMailService;

    public function __construct(BrainTreeCheckout $brainTreeCheckout, SendMailService $sendMailService)
    {
        $this->brainTreeCheckout = $brainTreeCheckout;
        $this->sendMailService = $sendMailService;
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
     * @return JsonResponse
     */
    public function transaction(Request $request, Swift_Mailer $mailer)
    {
        $data = json_decode($request->getContent(), true);
        $transaction = $this->brainTreeCheckout->createTransaction($data['amount'], $data['nonce']);

        if ($transaction->success) {

            $this
                ->sendMailService
                ->sendMail('Hello Email test',
                    'webphoto.studioludo@gmail.com',
                    'webphoto.studioludo@gmail.com',
                    '', $mailer);
        }

        return $this->json(
            $transaction
        );
    }


    /**
     * @Route("api/mail", name="mail")
     * @Method({"GET"})
     * @param Swift_Mailer $mailer
     * @return JsonResponse
     */
    public function testMail(\Swift_Mailer $mailer)
    {
        $template = $this->renderView(
        // templates/emails/registration.html.twig
            'emails/quotation.html.twig',
            array('name' => 'Test Mail')
        );

        return $this->json(
            $this->sendMailService
                ->sendMail(
                    'Hello Email test',
                    'webphoto.studioludo@gmail.com',
                    'webphoto.studioludo@gmail.com',
                    $template,
                    $mailer
                )
        );
    }

}
