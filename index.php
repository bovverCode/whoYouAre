<?php
/**
 * File contains entry site point.
 */

use Who\Controller\RouteController;
use Who\Exception\RouteException;
use Who\Service\ServiceHandler;
use Who\Exception\DatabaseException;

session_start();
require_once "settings.php";
date_default_timezone_set('Europe/Kiev');

/**
 * Autoloader
 */
require_once "vendor/autoload.php";

try {
  $routeController = RouteController::getInstance();
  $routeController->route();
} catch (RouteException $re) {
  ServiceHandler::getInstance()->getService('logger')->log($re->getCodeString(), $re->getMessage());
  exit($re->getUserMessage());
}