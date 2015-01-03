<?php

namespace Gnutix\Gratitude\Kernel;

use Gnutix\Gratitude\Controller;
use Gnutix\Gratitude\Mailer\SwiftMailer;
use Gnutix\Gratitude\Templating\TwigTemplatingEngine;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Application Kernel
 */
final class Kernel implements HttpKernelInterface
{
    const DEVELOPER_NAME = 'Dorian Villet';
    const DEVELOPER_EMAIL = 'gnutix@gmail.com';
    const EVERNOTE_EMAIL = 'gnutix.7e4c3e3@m.evernote.com';

    /** @var string */
    private $environment;

    /** @var string */
    private $debug;

    /** @var string */
    private $rootFolder;

    /** @var \Symfony\Component\DependencyInjection\Container */
    private $container;

    /** @var \Gnutix\Gratitude\Kernel\Router */
    private $router;

    /** @var \Gnutix\Gratitude\Controller */
    private $controller;

    /**
     * @param string $environment
     * @param bool   $debug
     * @param string $rootFolder
     */
    public function __construct($environment, $debug, $rootFolder)
    {
        $this->environment = $environment;
        $this->debug = $debug;
        $this->rootFolder = $rootFolder;
        $this->router = new Router();

        $this->boot();
    }

    /**
     * {@inheritDoc}
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        if ($type !== static::MASTER_REQUEST) {
            return new Response('Invalid request type', 500);
        }

        $this->configureContainer($request);

        $this->controller = new Controller($this->container);
        $action = $this->router->match($request->getPathInfo());

        if ( ! method_exists($this->controller, $action)) {
            return new Response('Page not found', 404);
        }

        return $this->controller->$action($request);
    }

    /**
     * Boots the kernel.
     */
    private function boot()
    {
        header('Content-type: text/html; charset=utf-8');

        if ($this->debug) {
            error_reporting(-1);
            ini_set('display_errors', true);
        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    private function configureContainer(Request $request)
    {
        $this->container = new Container();
        $this->container->setParameter('developer_email', array(static::DEVELOPER_EMAIL => static::DEVELOPER_NAME));
        $this->container->setParameter('evernote_email', static::EVERNOTE_EMAIL);
        $this->container->setParameter('smtp_host', 'smtp.mandrillapp.com');
        $this->container->setParameter('smtp_port', 587);
        $this->container->setParameter('smtp_username', static::DEVELOPER_EMAIL);
        $this->container->setParameter('smtp_password', 'QSoYW3LaxMHp_71p4Psoxw');

        $this->container->set('templating_engine', $this->getTemplatingEngine($request->getBaseUrl()));
        $this->container->set('mailer', $this->getMailer($request->getHost()));
    }

    /**
     * @param string $localDomain
     *
     * @return \Gnutix\Gratitude\Mailer\MailerInterface
     */
    private function getMailer($localDomain)
    {
        return new SwiftMailer(
            $this->container->getParameter('smtp_host'),
            $this->container->getParameter('smtp_port'),
            $this->container->getParameter('smtp_username'),
            $this->container->getParameter('smtp_password'),
            $localDomain,
            $this->debug
        );
    }

    /**
     * @param string $baseUrl
     *
     * @return \Gnutix\Gratitude\Templating\TemplatingEngineInterface
     */
    private function getTemplatingEngine($baseUrl)
    {
        return new TwigTemplatingEngine(
            array($this->rootFolder.'/app/Resources/views'),
            array('auto_reload' => true),
            array(new \Twig_Extension_Escaper(true)),
            array('baseUrl' => $baseUrl)
        );
    }
}
