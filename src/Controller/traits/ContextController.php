<?php

namespace Who\Controller\traits;

use Who\Controller\RouteController;
use Who\Model\BaseModel;
use Who\Service\ServiceHandler;
use Who\View\BaseView;

/**
 * Context Controller trait.
 * Helps write context controllers like admin/AuthController
 * without duplicating needle variables.
 */
trait ContextController {

  /**
   * @var $routeController RouteController
   */
  protected $routeController;

  /**
   * @var BaseView
   */
  protected $baseView;

  /**
   * @var BaseModel
   */
  protected $baseModel;

  /**
   * @var ServiceHandler
   */
  protected $serviceHandler;

  public function __construct() {
    $this->routeController = RouteController::getInstance();
    $this->baseView = BaseView::getInstance();
    $this->baseModel = BaseModel::getInstance();
    $this->serviceHandler = ServiceHandler::getInstance();
    $this->build();
    exit();
  }

  /**
   * Default function for every context controller.
   * The method should take all needle info from Model and build Page with BaseView.
   * Could be overwritten.
   */
  public function build() {
    $this->baseView->buildPage('user', ['404'=> '']);
  }

}