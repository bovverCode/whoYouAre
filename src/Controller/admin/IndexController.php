<?php

namespace Who\Controller\admin;

use Who\Controller\BaseController;
use Who\Controller\RouteController;
use Who\View\BaseView;

class IndexController extends BaseController {

  /**
   * @var $routeController RouteController
   */
  protected $routeController;

  /**
   * @var BaseView
   */
  protected $baseView;

  public function __construct() {
    $this->routeController = RouteController::getInstance();
    $this->baseView = BaseView::getInstance();

    $this->baseView->buildPage($this->routeController->get('routeType'), ['header' => '', 'footer' => '']);
  }

}
