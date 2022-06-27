<?php

namespace Who\Controller\user;

use Who\Controller\BaseController;
use Who\Controller\traits\ContextController;

class IndexController extends BaseController {

  use ContextController;

  public function __construct() {

    echo 'user index';

  }

}
