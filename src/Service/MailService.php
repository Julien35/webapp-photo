<?php

namespace App\Service;


use Swift_Mailer;
use Swift_Message;

class MailService
{
    public function sendContactMail()
    {

    }

    public function sendCheckoutMail()
    {
        // mail to client


        // mail to studio
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
        $isSent = false;

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
