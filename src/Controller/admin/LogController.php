<?php

namespace Who\Controller\admin;

use Who\Controller\BaseController;
use Who\Controller\traits\ContextController;
use Who\Service\Logger\Base;

class LogController extends BaseController {

  use ContextController;

  /**
   * @var Base
   */
  protected $logger;

  /**
   * {@inheritdoc}
   */
  protected function create() {
    $this->logger = $this->serviceHandler->getService('logger');
  }

  /**
   * {@inheritdoc}
   */
  protected function build() {
    $page = $this->routeController->get('options')['page'] ?? 1;
    $logs = $this->logger->getLogs($page);
    $this->baseView->buildPage($this->routeController->get('routeType'), [
    'header' => '',
    'logs' => ['logs' => $logs],
    'footer' => ''
    ]);
  }

}
