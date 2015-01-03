<?php

namespace Gnutix\Gratitude\Templating;

/**
 * Templating engine implementation using Twig
 */
final class TwigTemplatingEngine implements TemplatingEngineInterface
{
    /** @var string[] */
    private $templatesPaths;

    /** @var array */
    private $configuration;

    /** @var \Twig_ExtensionInterface[] */
    private $extensions;

    /** @var array */
    private $globalContext;

    /** @var \Twig_Environment */
    private $twig;

    /**
     * @param string|array $templatesPaths
     * @param array        $configuration
     * @param array        $extensions
     * @param array        $globalContext
     */
    public function __construct(
        $templatesPaths,
        array $configuration = array(),
        array $extensions = array(),
        array $globalContext = array()
    ) {
        $this->templatesPaths = $templatesPaths;
        $this->configuration = $configuration;
        $this->extensions = $extensions;
        $this->globalContext = $globalContext;
    }

    /**
     * @param string $name
     * @param array  $context
     *
     * @return string
     */
    public function render($name, array $context = array())
    {
        return $this->getTwigEnvironment()->render($name, array_merge($this->globalContext, $context));
    }

    /**
     * @return \Twig_Environment
     */
    private function getTwigEnvironment()
    {
        if ( ! ($this->twig instanceof \Twig_Environment)) {
            $this->twig = new \Twig_Environment(
                new \Twig_Loader_Filesystem($this->templatesPaths),
                $this->configuration
            );

            foreach ($this->extensions as $extension) {
                $this->twig->addExtension($extension);
            }
        }

        return $this->twig;
    }
}
