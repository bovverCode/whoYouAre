<?php

namespace Who\Controller\admin;

use Who\Controller\BaseController;
use Who\Controller\traits\ContextController;

class IndexController extends BaseController {

  use ContextController;

  /**
   * {@inheritdoc}
   */
  protected function build() {
    // Redirect to auth if not logged in.
    if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
      header('Location: /admin/auth');
      die();
    }
//    $this->baseModel->read('fuck');
    $time = date('m/d/Y h:i:s a', time());
    $this->baseView->buildPage($this->routeController->get('routeType'), [
      'header' => '',
      'index' => ['time' => $time],
      'footer' => ''
    ]);
  }

}
