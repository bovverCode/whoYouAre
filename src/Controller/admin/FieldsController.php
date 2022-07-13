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
   */
  protected function build() {
    $pathOptions = $this->routeController->get('options');
    if ($this->routeController->get('requestMethod') === 'GET') {
      # Get request method.
      if (isset($pathOptions['group']) && is_numeric($pathOptions['group'])) {
        $this->buildFieldsPage($pathOptions['group']);
      } else {
        $this->buildGroupsPage();
      }
    } else {
      # POST request method.
      if (isset($pathOptions['add-group'])) $this->ajaxCreateGroup();
    }
  }

  /**
   * Method find groups and builds groups page.
   *
   * @return void
   *
   * @throws \Exception
   */
  public function buildGroupsPage() {
    $groups = $this->fieldsService->group->getGroups();
    $this->baseView->buildPage($this->routeController->get('routeType'), [
      'header' => '',
      'field_groups' => ['groups' => $groups],
      'footer' => ''
    ]);
  }

  /**
   * Create group on ajax call.
   *
   * @return void
   */
  public function ajaxCreateGroup() {
    $response = [];
    if (isset($_POST['group_name']) && strlen($_POST['group_name']) > 0) {
      $name = $_POST['group_name'];
      if (isValidSlug($name) && strlen($name) < 255) {
        # Check if group with this name exist.
        $duplicate = $this->fieldsService->group->getGroup($name);
        if (!empty($duplicate)) {
          # Exist.
          $response['error'][] = 'Group with name: ' . $name . ' already exist.';
        } else {
          # Finally create group.
          $this->fieldsService->group->createGroup($name);
          $info = $this->fieldsService->group->getGroup($name);
          $info = reset($info);
          $response['success'] = $info;
        }
      } else {
        $response['error'][] = 'Group name should contain english characters and "_" symbol (max 255 chars.).';
      }
    } else {
      $response['error'][] = 'Group name is required.';
    }
    echo json_encode($response);
    die();
  }

  /**
   * Create fields page of some group.
   *
   * @param int $group_id
   *   Group id.
   *
   * @return void
   *
   * @throws RouteException
   */
  public function buildFieldsPage(int $group_id) {
    $group = $this->fieldsService->group->getGroupById($group_id);
    $group = reset($group);
    if (empty($group)) {
      throw new RouteException('Group with ID: ' . $group_id . ' not exist.', 0);
    }
    $fields = $this->fieldsService->getFieldsByGroup($group_id);
    $types = implode(',', $this->fieldsService->getFieldTypes());
    $this->baseView->buildPage($this->routeController->get('routeType'), [
      'header' => '',
      'group_fields' => ['fields' => $fields, 'group' => $group, 'types' => $types],
      'footer' => ''
    ]);
  }

}