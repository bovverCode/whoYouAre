<?php

namespace Who\Controller;

/**
 * Base site controller.
 */
abstract class BaseController {

  protected $routeType = '';

  protected $controller = '';

  protected $requestMethod = 'GET';

  protected $options = [];

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

