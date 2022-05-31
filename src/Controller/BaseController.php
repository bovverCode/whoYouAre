<?php

namespace Who\Controller;

/**
 * Base site controller.
 */
class BaseController {

  private static $instance;

  protected $routeType = '';

  protected $controller = '';

  protected $options = [];

  /**
   * Singleton method construct.
   */
  protected function __construct() { }

  /**
   * Singleton method clone.
   */
  protected function __clone() { }

  /**
   * Static method to get instance of self.
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      return self::$instance = new static();
    }
    return self::$instance;
  }

  /**
   * Method to set up needle variables in the BaseController Class.
   */
  public function route() {

    if ($_SERVER['REQUEST_METHOD'] === "GET") {

      $path = trim( $_SERVER['REQUEST_URI'], '/');
      $path = explode('/', $path);
      array_shift($path);

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

      $controllerInstance = new $class;

    }

  }

}

