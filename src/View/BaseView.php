<?php
/**
 * File contains base view class.
 */

namespace Who\View;

use Who\Controller\traits\Singleton;

class BaseView {

  use Singleton;

  /**
   * Method to build page using template.
   *
   * $templateType - string 'admin' or 'user'
   * $options is an array like:
   * [
   *  'header' => [
   *    'logo' => ['src' => 'logo.png', 'alt' => 'cool_image'],
   *    'name' => 'William',
   *    'is_me' => false,
   *  ],
   *  'body' => ... ,
   * ]
   */
  public function buildPage($templateType, $options) {
    $path = TEMPLATE_PATH . $templateType;
    foreach ($options as $template => $values) {
      if (file_exists("$path/$template.php")) {
        include "$path/$template.php";
      } else {
        throw new \Exception("File: $path/$template.php not exist.");
      }
    }
  }

  /**
   * Create css link.
   */
  public function getLink($src) {
    return '<link rel="stylesheet" href="' . SITE_PATH . $src . '">';
  }

  /**
   * Create js link.
   */
  public function getScript($src) {
    return '<script src="' . SITE_PATH . $src . '"></script>';
  }


}