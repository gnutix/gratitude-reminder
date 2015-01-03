<?php

namespace Gnutix\Gratitude\Templating;

/**
 * Interface for a templating engine
 */
interface TemplatingEngineInterface
{
    /**
     * @param string $name
     * @param array  $context
     *
     * @return string
     */
    public function render($name, array $context = array());
}
