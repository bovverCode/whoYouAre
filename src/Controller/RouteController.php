<?php

namespace Who\Controller;

use Who\Controller\traits\Singleton;

class RouteController extends BaseController {

  use Singleton;

  protected $routeType = '';

  protected $controller = '';

  protected $requestMethod = 'GET';

  protected $options = [];

  /**
   * Method to set up needle variables in the BaseController Class.
   */
  public function route() {

    // Actual path.
    $path = $_SERVER['REQUEST_URI'];
    $path = substr($path, strlen(SITE_PATH));

    // Check if path ends with '/'.
    if (substr($path, strlen($path) - 1, 1) === '/') {
      $path = substr($path, 0, strlen($path) -1);
      // Redirect to path without '/' at the end.
      header('Location: /' . $path);
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
        //index controller
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
    $class = "Who\\Controller\\" . $this->routeType . "\\" . ucfirst($this->controller) . 'Controller';

    if (class_exists($class)) {
        $controllerInstance = new $class;
    } else {
        throw new \Exception('Class: ' . $class . ' not exist.');
    }

  }

}