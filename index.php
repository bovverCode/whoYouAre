<?php

/**
 * Autoloader PSR4
 */
require_once realpath("vendor/autoload.php");

use Who\Controller\BaseController;

try {
  $baseController = BaseController::getInstance();
  $baseController->route();
} catch (Exception $exception) {
  echo ($exception->getMessage());
}
