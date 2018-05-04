<?php

namespace App\Controller;

use App\Service\BrainTreeCheckout;
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
     * @param Swift_Mailer $mailer
     * @return JsonResponse
     */
    public function transaction(Request $request, \Swift_Mailer $mailer)
    {
        $data = json_decode($request->getContent(), true);
        $transaction = $this->brainTreeCheckout->createTransaction($data['amount'], $data['nonce']);

        if ($transaction->success) {
            $this->sendMail('test mail', $mailer);
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
        return $this->json(
            $this->sendMail('test mail', $mailer)
        );
    }

    /**
     * @param $name
     * @param \Swift_Mailer $mailer
     * @return int
     */
    public function sendMail($name, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('mail@gmail.com')
            ->setTo('mail@gmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/quotation.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            );

        $isSent = false;
        if ($mailer->send($message, $failures)) {
//            todo: always true on failure

            $isSent = true;
//            echo ' SUCCESS SENDING!:';
        } else {
//            echo ' SENDING ERROR TO :' . print_R($failures);
        }


        return $isSent;
    }
}