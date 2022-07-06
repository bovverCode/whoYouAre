<?php
/**
 * Class represents 404 controller.
 */

namespace Who\Controller\user;

use Who\Controller\BaseController;
use Who\Controller\traits\ContextController;

class OopsController extends BaseController {

  use ContextController;

  /**
   * {@inheritdoc}
   */
  protected function build() {
    $this->baseView->buildPage('user', [
      'header' => '',
      'oops' => '',
      'footer' => ''
    ]);
  }
}