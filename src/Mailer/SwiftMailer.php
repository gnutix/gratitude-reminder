<?php

namespace Gnutix\Gratitude\Mailer;

/**
 * Mailer implementation using SwiftMailer.
 */
final class SwiftMailer implements MailerInterface
{
    /** @var \Swift_Mailer */
    private $mailer;

    /**
     * @param string $smtpHost
     * @param string $smtpPort
     * @param string $smtpUsername
     * @param string $smtpPassword
     * @param string $localDomain
     * @param bool   $debug
     */
    public function __construct($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $localDomain, $debug = false)
    {
        $transport = \Swift_SmtpTransport::newInstance($smtpHost, $smtpPort)
            ->setUsername($smtpUsername)
            ->setPassword($smtpPassword)
            ->setLocalDomain($localDomain);

        $this->mailer = \Swift_Mailer::newInstance($transport);

        if ($debug) {
            $this->mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin(new \Swift_Plugins_Loggers_EchoLogger()));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function send($sender, $subject, $content, $recipients)
    {
        $swiftMessage = new \Swift_Message($subject, $content, 'text/html', 'UTF-8');
        $swiftMessage->setFrom($sender);
        $swiftMessage->setTo($recipients);

        return $this->mailer->send($swiftMessage);
    }
}
