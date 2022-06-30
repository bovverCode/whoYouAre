<?php

namespace Who\Exception;

/**
 * Database exception class.
 */
class DatabaseException extends BaseException {

  /**
   * {@inheritdoc}
   */
  public $codes = [
    0 => 'Wrong query',
  ];

}