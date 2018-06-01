<?php

namespace App\Service;


use Swift_Mailer;
use Swift_Message;

class SendMailService
{
    public function sendContactMail()
    {

    }

    public function sendCheckoutMail()
    {

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
//            todo: always true on failure ?
            $isSent = true;
            echo ' SUCCESS SENDING!:';
        } else {
            echo ' SENDING ERROR TO :' . print_R($failures);
        }


        return $isSent;
    }

}
