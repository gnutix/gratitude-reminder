<?php

namespace Gnutix\Gratitude\Mailer;

/**
 * Represents a message.
 */
final class Message
{
    /** @var string */
    private $sender;

    /** @var string */
    private $subject;

    /** @var string */
    private $content;

    /** @var string|string[] */
    private $recipients;

    /** @var string|string[] */
    private $replyTo;

    /**
     * @param string          $sender
     * @param string          $subject
     * @param string          $content
     * @param string|string[] $recipients
     * @param string|string[] $replyTo
     */
    public function __construct($sender, $subject, $content, $recipients, $replyTo = '')
    {
        $this->sender = $sender;
        $this->subject = $subject;
        $this->content = $content;
        $this->recipients = $recipients;
        $this->replyTo = $replyTo;
    }

    /**
     * @param \Gnutix\Gratitude\Mailer\MailerInterface $mailer
     *
     * @return bool
     */
    public function send(MailerInterface $mailer)
    {
        return $mailer->send($this->sender, $this->subject, $this->content, $this->recipients, $this->replyTo);
    }
}
