<?php

namespace Who\Controller\admin;

use Who\Controller\BaseController;
use Who\Controller\traits\ContextController;

/**
 * Class provides logout from admin panel functionality.
 */
class LogoutController extends BaseController {

  use ContextController;

  /**
   * {@inheritdoc}
   */
  protected function build() {
    // Redirect to auth if not logged in.
    if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
      header('Location: /admin/auth');
      die();
    } else {
      // Remove session cookie and redirect to auth page.
      unset($_SESSION['auth']);
      header('Location: /admin/auth');
      die();
    }

  }

}

