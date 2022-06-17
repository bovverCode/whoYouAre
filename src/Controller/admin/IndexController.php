<?php

namespace Who\Controller\admin;

use Who\Controller\BaseController;
use Who\Controller\RouteController;
use Who\Controller\traits\ContextController;
use Who\View\BaseView;

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
    $this->baseView->buildPage($this->routeController->get('routeType'), ['header' => '', 'footer' => '']);
  }

}
