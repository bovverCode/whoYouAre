<?php

namespace Who\Controller\admin;

use Who\Controller\BaseController;
use Who\Controller\traits\ContextController;

class LogController extends BaseController {

  use ContextController;

  /**
   * {@inheritdoc}
   */
  protected function build() {
    $logs = [];
    $this->serviceHandler->getService('logger');
    $this->baseView->buildPage($this->routeController->get('routeType'), [
    'header' => '',
    'logs' => ['logs' => $logs],
    'footer' => ''
    ]);
  }

}
