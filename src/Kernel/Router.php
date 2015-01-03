<?php

namespace Gnutix\Gratitude\Kernel;

/**
 * Maps URIs to controller actions
 */
final class Router
{
    /**
     * @param string $uri
     *
     * @return string
     */
    public function match($uri)
    {
        if ('/reminder' === $uri) {
            return 'reminderAction';
        }

        return 'defaultAction';
    }
}
