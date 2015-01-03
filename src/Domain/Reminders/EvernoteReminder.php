<?php

namespace Gnutix\Gratitude\Domain\Reminders;

use Gnutix\Gratitude\Mailer\MailerInterface;
use Gnutix\Gratitude\Mailer\Message;
use Gnutix\Gratitude\Templating\TemplatingEngineInterface;

/**
 * Reminds me to be grateful.
 */
final class EvernoteReminder
{
    /** @var \Gnutix\Gratitude\Templating\TemplatingEngineInterface */
    private $templatingEngine;

    /** @var \Gnutix\Gratitude\Mailer\MailerInterface */
    private $mailer;

    /** @var string */
    private $senderEmail;

    /** @var string */
    private $recipientEmail;

    /**
     * @param \Gnutix\Gratitude\Templating\TemplatingEngineInterface $templatingEngine
     * @param \Gnutix\Gratitude\Mailer\MailerInterface               $mailer
     * @param string                                                 $senderEmail
     * @param string                                                 $recipientEmail
     */
    public function __construct(
        TemplatingEngineInterface $templatingEngine,
        MailerInterface $mailer,
        $senderEmail,
        $recipientEmail
    ) {
        $this->mailer = $mailer;
        $this->templatingEngine = $templatingEngine;
        $this->senderEmail = $senderEmail;
        $this->recipientEmail = $recipientEmail;
    }

    /**
     * @return bool
     */
    public function remind()
    {
        $message = new Message(
            array($this->senderEmail => 'My evernote account'),
            'Be grateful today! @Gratefulness',
            $this->templatingEngine->render('reminder_email.html.twig'),
            $this->recipientEmail
        );

        return $message->send($this->mailer);
    }
}
