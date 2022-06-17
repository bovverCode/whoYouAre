<?php
/**
 * File contains entry site point.
 */

use Who\Controller\RouteController;

session_start();
require_once "settings.php";

/**
 * Autoloader PSR4
 */
require_once "vendor/autoload.php";

try {
  $routeController = RouteController::getInstance();
  $routeController->route();
} catch (Exception $exception) {
  exit($exception->getMessage());
}

