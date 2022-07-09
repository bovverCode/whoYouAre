<?php

namespace Who\Controller\user;

use Who\Controller\BaseController;
use Who\Controller\traits\ContextController;

class WhoWeAreController extends BaseController {

  use ContextController;

  /**
   * {@inheritdoc}
   */
  protected function build() {
    $this->baseView->buildPage($this->routeController->get('routeType'), [
      'header' => '',
      'about' => '',
      'footer' => ''
    ]);
  }

}
