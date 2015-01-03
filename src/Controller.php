<?php

namespace Gnutix\Gratitude;

use Gnutix\Gratitude\Mailer\SwiftMailer;
use Gnutix\Gratitude\Reminders\EvernoteReminder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Create the responses according to the request
 */
final class Controller
{
    /** @var \Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function defaultAction()
    {
        return new Response($this->getTemplatingEngine()->render('default.html.twig'));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reminderAction(Request $request)
    {
        if ( ! $request->isMethod('POST')) {
            return new Response('This page can only be called using POST.', 405);
        }

        $reminder = new EvernoteReminder(
            $this->getTemplatingEngine(),
            $this->getMailer(),
            $this->container->getParameter('evernote_email'),
            $this->container->getParameter('developer_email')
        );

        return new Response(
            $this->getTemplatingEngine()->render(
                'reminder.html.twig',
                array('reminderSentSuccessfully' => $reminder->remind())
            )
        );
    }

    /**
     * @return \Gnutix\Gratitude\Mailer\MailerInterface
     */
    private function getMailer()
    {
        return $this->container->get('mailer');
    }

    /**
     * @return \Gnutix\Gratitude\Templating\TemplatingEngineInterface
     */
    private function getTemplatingEngine()
    {
        return $this->container->get('templating_engine');
    }
}
