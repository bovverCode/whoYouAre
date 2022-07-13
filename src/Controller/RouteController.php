<?php

namespace Who\Controller;

use Who\Controller\traits\Singleton;
use Who\Exception\RouteException;
use Who\Service\Logger\Base;
use Who\Service\ServiceHandler;

class RouteController extends BaseController {

  use Singleton;

  protected $routeType = '';

  protected $controller = '';

  protected $requestMethod = 'GET';

  protected $options = [];

  /**
   * @var ServiceHandler
   */
  protected $serviceHandler;

  /**
   * @var Base
   */
  protected $logger;

  /**
   * Method to set up needle variables in the BaseController Class.
   */
  public function route() {
    $this->serviceHandler = ServiceHandler::getInstance();
    $this->logger = $this->serviceHandler->getService('logger');
    // Actual path.
    $path = $_SERVER['REQUEST_URI'];
    $path = substr($path, strlen(SITE_PATH));

    // Check if path ends with '/'.
    if (substr($path, strlen($path) - 1, 1) === '/') {
      $path = substr($path, 0, strlen($path) -1);
      // Redirect to path without '/' at the end.
      header('Location: ' . SITE_PATH . $path);
      die();
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      $this->requestMethod = 'POST';
    }

    if ($path) {
        $path = explode('/', $path);
    } else $path = [];

    if (isset($path[0]) && $path[0] === 'admin') {
      // admin route
      $this->routeType = 'admin';
      array_shift($path);

      if (isset($path[0])) {
        $this->controller = $path[0];
        array_shift($path);
      } else {
        $this->controller = 'index';
      }

    } else {
      // user route
      $this->routeType = 'user';
      if (isset($path[0])) {

        $this->controller = $path[0];
        array_shift($path);

      } else {
        // index controller
        $this->controller = 'index';
      }

    }

    $i = null;
    foreach ($path as $item) {
      $item = strtolower($item);
      if ($i === null) {
        $this->options[$item] = '';
        $i = $item;
      } else {
        $this->options[$i] = $item;
        $i = null;
      }
    }

    $this->controller = strtolower($this->controller);
    # Url with hyphen.
    $words = explode('-', $this->controller);
    if (count($words) > 1) {
      $this->controller = '';
      foreach ($words as $word) {
        $this->controller .= ucfirst($word);
      }
    }
    $class = "Who\\Controller\\" . $this->routeType . "\\" . ucfirst($this->controller) . 'Controller';

    if (class_exists($class)) {
        $controllerInstance = new $class;
    } else {
        throw new RouteException('Class: ' . $class . ' not exist.', 0);
    }

  }

}