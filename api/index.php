<?php

# Session lifetime of 20 hours
ini_set('session.gc_maxlifetime', 20 * 60 * 60);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
if (!file_exists(__DIR__ . '/sessions')) {
    mkdir(__DIR__ . '/sessions', 0777, true);
}
session_save_path(__DIR__ . '/sessions');

session_start();

require 'vendor/autoload.php';

/* --- System --- */
require 'systems/domain.php';
require 'systems/database.php';
require 'systems/systems.php';
require 'systems/functions.php';
if (file_exists('vendor/cahkampung/landa-php/src/LandaPhp.php')) {
    require 'vendor/cahkampung/landa-php/src/LandaPhp.php';
}

$display = (getenv('DISPLAY_ERRORS') == 'true') ? true : false;

$config = [
    'displayErrorDetails'               => $display,
    'determineRouteBeforeAppMiddleware' => true,
];

$app = new \Slim\App(["settings" => $config]);

require 'systems/dependencies.php';
require 'systems/middleware.php';

/** route to php file */
$file = getUrlFile();
require $file;

$app->run();
