<?php

use Symfony\Component\HttpFoundation\Request;
use Gnutix\Gratitude\Kernel\Kernel;

require_once __DIR__.'/../vendor/autoload.php';

$kernel = new Kernel('prod', (bool) getenv('SYMFONY_DEBUG'), __DIR__.'/..');
$response = $kernel->handle(Request::createFromGlobals());
$response->send();
