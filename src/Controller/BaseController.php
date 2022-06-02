<?php

namespace Who\Controller;

/**
 * Base site controller.
 */
abstract class BaseController {

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

  /**
   * Method to get class option.
   */
  public function get($option) {
    if (!empty($option)) {
      if (is_array($option)) {
        $arr = [];
        foreach ($option as $opt) {
          if (isset($this->$opt)) {
            $arr[$opt] = $this->$opt;
          }
          return $arr;
        }
      } else {
        if (isset($this->$option)) {
          return $this->$option;
        }
      }
    }
    return false;
  }

  /**
   * Method to set class option.
   */
  public function set($option, $value) {
    if (isset($this->$option)) {
      $this->$option = $value;
    }
  }

}

