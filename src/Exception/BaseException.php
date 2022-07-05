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
    $this->writeLogFile($this->getCodeString(), $this->getFile(), $this->getLine(), $this->getTraceAsString(), $this->getMessage());
  }

  /**
   * Write log message to local file.
   *
   * @param $code
   *  Exception code string version.
   * @param $filename
   *  Name of file where error happen.
   * @param $line
   *  Line of the file.
   * @param $trace
   *  Stack trace.
   * @param $message
   *  Exception message.
   * @return void
   */
  public function writeLogFile($code, $filename, $line, $trace, $message) {
     $file = fopen(LOG_FILE, 'ab');
     $text = "Time: " . date('m/d/Y h:i:s a', time()) . ". \n";
     $text .= "Problem: $code \n";
     $text .= "Filename: $filename, line number $line. \n";
     $text .= "Trace: $trace. \n";
     $text .= "Message: $message \n";
     $text .= str_repeat('=', 10) . "\n";
     fwrite($file, $text);
     fclose($file);
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