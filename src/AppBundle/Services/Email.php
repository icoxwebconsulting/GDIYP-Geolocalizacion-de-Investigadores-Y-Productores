<?php

namespace AppBundle\Services;

use Symfony\Component\Templating\EngineInterface;

class Email
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }
    
    public function sendContactEmail($receptor, $data)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($data['subject'])
            ->setFrom($data['email'])
            ->setTo($receptor)
            ->setBody($data['message']);
        return $this->mailer->send($message);
    }
}