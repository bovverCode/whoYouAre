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
    # Prepare values for view.
    $page = 1;
    if (isset($this->routeController->get('options')['page'])) {
      $page = is_numeric($this->routeController->get('options')['page']) ?
      $this->routeController->get('options')['page'] : 1;
    }
    # Log items.
    $logs = $this->logger->getLogs($page);
    # Logs total count.
    $count = $this->logger->getTotalCount();
    $this->baseView->buildPage($this->routeController->get('routeType'), [
    'header' => '',
    'logs' => ['logs' => $logs, 'count' => $count],
    'footer' => ''
    ]);
  }

}
