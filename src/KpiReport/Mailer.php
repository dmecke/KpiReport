<?php

namespace KpiReport;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Swift_Message
     */
    private $message;

    /**
     * @param \Swift_Mailer $mailer
     * @param \Swift_Message $message
     */
    public function __construct(\Swift_Mailer $mailer, \Swift_Message $message)
    {
        $this->mailer = $mailer;
        $this->message = $message;
    }

    /**
     * @param string $receiver
     * @param string $subject
     * @param string $body
     *
     * @return int
     */
    public function sendMessage($receiver, $subject, $body)
    {
        $this->message->setTo($receiver);
        $this->message->setSubject($subject);
        $this->message->setBody(strip_tags($body));
        $this->message->addPart($body, 'text/html');

        return $this->mailer->send($this->message);
    }
}
