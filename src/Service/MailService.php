<?php

namespace App\Service;


use App\Entity\Cart;
use App\Entity\Contact;
use Psr\Container\ContainerInterface;
use Swift_Mailer;
use Swift_Message;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailService
{

    private $twig_engine;

    private $mailer;

    private $mailerFrom;

    private $mailerTo;

    public function __construct(ContainerInterface $container, Swift_Mailer $mailer)
    {
        $this->twig_engine = $container->get('twig');
        $this->mailer = $mailer;
        $this->mailerFrom = $_ENV['MAILER_FROM'];
        $this->mailerTo = $_ENV['MAILER_TO'];
    }


    /**
     * @param Contact $contact
     * @return bool
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendContactMail(Contact $contact)
    {
        $template = $this->twig_engine->render(
            'emails/contact.html.twig',
            array('name' => $contact->getName())
        );

        $isSent = $this->sendMail(
            'Hello Email test',
            $this->mailerFrom,
            [$this->mailerTo, $contact->getEmail()],
            $template
        );

        return $isSent;
    }

    /**
     * @param Cart $cart
     * @return bool
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendCheckoutMail(Cart $cart)
    {
        $template = $this->twig_engine->render(
            'emails/quotation.html.twig',
            array('name' => 'Test Mail')
        );

        $isSent = $this->sendMail(
            'Hello Email test',
            $this->mailerFrom,
            [$this->mailerTo, $cart->getRegistration()->getEmail()],
            $template
        );

        return $isSent;
    }


    /**
     * @param $subject
     * @param $from
     * @param $to
     * @param $mailBody
     * @return bool
     */
    private function sendMail($subject, $from, $to, $mailBody)
    {
        $message = new Swift_Message();
        $message
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($mailBody, 'text/html');

        $isSent = false;

        $sent = $this->mailer->send($message, $failures);
        if ($sent && empty($failures)) {
            $isSent = true;
        }

        return $isSent;
    }

}
