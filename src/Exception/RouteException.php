<?php

namespace Who\Exception;

/**
 * Routing exception class.
 */
class RouteException extends BaseException {

  /**
   * {@inheritdoc}
   */
  public $codes = [
    0 => 'Wrong route',
  ];

}