<?php

namespace App\Service;


use App\Entity\Cart;
use Psr\Container\ContainerInterface;
use Swift_Mailer;
use Swift_Message;

class MailService
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function sendContactMail()
    {

    }

    public function sendCheckoutMail(Cart $cart, Swift_Mailer $mailer)
    {
        $isSent = false;

        $template = $this->container->get('twig')->render(
        // templates/emails/registration.html.twig
            'emails/quotation.html.twig',
            array('name' => 'Test Mail')
        );

        $isSent = $this->sendMail(
            'Hello Email test',
            'webphoto.studioludo@gmail.com',
            'webphoto.studioludo@gmail.com',
            $template,
            $mailer
        );

        // mail to studio


        return $isSent;
    }


    /**
     * @param $subject
     * @param $from
     * @param $to
     * @param $mailBody
     * @param Swift_Mailer $mailer
     * @return int
     */
    public function sendMail($subject, $from, $to, $mailBody, Swift_Mailer $mailer)
    {
        $message = new Swift_Message();
        $message
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($mailBody, 'text/html');

        $isSent = false;

        $sent = $mailer->send($message, $failures);
        if ($sent && empty($failures)) {
            $isSent = true;
        }

        return $isSent;
    }

}
