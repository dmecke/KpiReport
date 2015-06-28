<?php

namespace KpiReport;

class Sender
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var array
     */
    private $receiver;

    /**
     * @param Mailer $mailer
     * @param Generator $generator
     * @param array $receiver
     */
    public function __construct(Mailer $mailer, Generator $generator, array $receiver)
    {
        $this->mailer = $mailer;
        $this->generator = $generator;
        $this->receiver = $receiver;
    }

    /**
     * @param string $subject
     * @param string $report
     */
    public function send($subject, $report)
    {
        foreach ($this->receiver as $receiver) {
            $this->mailer->sendMessage($receiver, $subject, $this->generator->generate($report));
        }
    }
}
