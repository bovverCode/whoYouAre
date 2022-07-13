<?php
/**
 * Helper functions.
 */

/**
 * Error handler for unexpected errors.
 */
function error_handler($errno, $errstr, $errfile, $errline) {
  $file = fopen(FATAL_LOG_FILE, 'ab');
  $text = "Time: " . date('m/d/Y h:i:s a', time()) . ". \n";
  $text .= "Problem: $errstr \n";
  $text .= "Filename: $errfile, line number $errline. \n";
  $text .= str_repeat('=', 10) . "\n";
  fwrite($file, $text);
  fclose($file);
  exit('Something goes wrong. Contact <a href="' . ADMIN_HREF . '">admin</a> or jump to <a href="/">homepage</a>');
}

/**
 *  Check if slug use only eng chars and '_' symbol.
 *
 * @param $slug
 *  Slug to check.
 *
 * @return bool
 */
function isValidSlug($slug) {
  # Check if string contains only english characters and '_';
  $pattern = '/[a-zA-Z]|_*/';
  $wrongCharacters = preg_replace($pattern, '', $slug);
  return strlen($wrongCharacters) === 0;
}