<?php

namespace Gnutix\Gratitude\Mailer;

/**
 * Represents a mailer.
 */
interface MailerInterface
{
    /**
     * @param string          $sender
     * @param string          $subject
     * @param string          $content
     * @param string|string[] $recipients
     * @param string|string[] $replyTo
     *
     * @return bool
     *
     */
    public function send($sender, $subject, $content, $recipients, $replyTo = '');
}
