<?php

/**
 * Implementation of fields admin page.
 */

namespace Who\Controller\admin;

use Who\Controller\BaseController;
use Who\Controller\traits\ContextController;
use Who\Exception\RouteException;
use Who\Service\Fields\Base;

/**
 * Class represents fields page controller.
 */
class FieldsController extends BaseController {

  use ContextController;

  /**
   * Fields service instance.
   *
   * @var Base
   */
  protected $fieldsService;

  /**
   * {@inheritdoc}
   */
  protected function create() {
    $this->fieldsService = $this->serviceHandler->getService('fields');
  }

  /**
   * {@inheritdoc}
   *
   * @throws RouteException
   */
  protected function build() {
    echo 'Hello';
  }

}