<?php
/**
 * File contains base view class.
 */

namespace Who\View;

use Who\Controller\RouteController;
use Who\Controller\traits\Singleton;

class BaseView {

  use Singleton;

  /**
   * @var RouteController
   */
  protected $routeController;

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static();
      self::$instance->routeController = RouteController::getInstance();
      return self::$instance;
    }
    return self::$instance;
  }

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

  /**
   * Get favicon.
   */
  public function getFavIcon() {
    return '<link rel="icon" type="image/x-icon" href="' . SITE_PATH . FAVICON . '">';
  }

  /**
   * Get pagination.
   *
   * @param $total int
   * @param $perPage int
   * @return string
   */
  public function getPagination($total, $perPage = 10) {
    # Prepare path for pagination items.
    $routeType = $this->routeController->get('routeType');
    $routeType = $routeType === 'user' ? '' : 'admin/';
    $controller = $this->routeController->get('controller');
    $path = SITE_PATH . $routeType . $controller;
    $pagination = '<div class="pagination">';
    $pages = ceil($total / $perPage);
    for ($i = 1; $i <= $pages; $i++) {
      $pagination .= "<a href='$path/page/$i' class='pagination-item'> $i </a>";
    }
    $pagination .= '</div>';
    return $pagination;
  }

}