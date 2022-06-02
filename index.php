<?php

use Who\Controller\RouteController;

/**
 * Autoloader PSR4
 */
require_once realpath("vendor/autoload.php");

try {
  $routeController = RouteController::getInstance();
  $routeController->route();
} catch (Exception $exception) {
  exit($exception->getMessage());
}

