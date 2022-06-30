<?php

namespace Who\Exception;

use Throwable;

/**
 * Base exception class.
 */
abstract class BaseException extends \Exception {

  /**
   * Exception codes with text.
   *
   * @var array
   */
  public $codes = [];

  /**
   * {@inheritdoc}
   */
  public function __construct($message = "Message missed", $code = 0, Throwable $previous = null) {
    if (!array_key_exists($code, $this->codes)) $code = 0;
    parent::__construct($message, $code, $previous);
  }

  /**
   * Exception code to string.
   *
   * @return string
   */
  public function getCodeString() {
    return $this->codes[$this->getCode()];
  }

  /**
   * Default user message on Exception.
   *
   * @return string
   */
  public function getUserMessage() {
    $message = 'Something goes wrong. Contact <a href="' . ADMIN_HREF . '">admin</a> or jump to <a href="/">homepage</a>';
    return $message;
  }

}