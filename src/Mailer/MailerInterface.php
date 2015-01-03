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
     *
     * @return bool
     *
     */
    public function send($sender, $subject, $content, $recipients);
}
