<?php

namespace Who\Controller\traits;

trait Singleton {

  private static $instance;

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

}