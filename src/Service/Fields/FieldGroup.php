<?php

/**
 * Part of fields plugin.
 * Implementation of field group functionality.
 */

namespace Who\Service\Fields;

use Who\Controller\traits\Singleton;
use Who\Model\BaseModel;

/**
 * Field group functionality class.
 */
class FieldGroup {

  use Singleton;

  /**
   * BaseModel class instance.
   *
   * @var BaseModel
   */
  protected BaseModel $baseModel;

  /**
   * Field groups table name.
   *
   * @var string
   */
  protected string $table;

  /**
   * {@inheritdoc}
   */
  public static function getInstance(BaseModel $baseModel, string $table) {
    if (!isset(self::$instance)) {
      self::$instance = new static();
      self::$instance->baseModel = $baseModel;
      self::$instance->table = $table;
      return self::$instance;
    }
    return self::$instance;
  }

  /**
   * Get field groups
   *
   * @return array
   *  Assoc array with id and name keys.
   */
  public function getGroups() {
    return $this->baseModel->read($this->table);
  }

  /**
   * Get group by name.
   *
   * @param string $name
   *  Name of needed group.
   *
   * @return array
   */
  public function getGroup(string $name) {
    return $this->baseModel->read($this->table, [
      'where' => ['name' => ['=', $name]],
    ]);
  }

  /**
   * Get group by id.
   *
   * @param int $id
   *  ID of needed group.
   *
   * @return array
   */
  public function getGroupById(int $id) {
    return $this->baseModel->read($this->table, [
      'where' => ['id' => ['=', $id]],
    ]);
  }

  /**
   * Create new group.
   *
   * @param string $name
   *  Name of new group.
   *
   * @return void
   */
  public function createGroup(string $name) {
    $this->baseModel->create($this->table, ['name'], [$name]);
  }

  /**
   * Remove group by id.
   *
   * @param int $id
   *  Group ID.
   *
   * @return void
   */
  public function removeGroup(int $id) {
    $this->baseModel->delete($this->table, [
      'where' => ['id' => ['=', $id]],
    ]);
  }

  /**
   * Update group name by id.
   *
   * @param int $id
   *   ID of group.
   *
   * @param string $name
   *  New group name.
   *
   * @return void
   */
  public function updateGroupName(int $id, string $name) {
    $this->baseModel->update($this->table, [
      'fields' => [
        'name' => $name,
      ],
      'where' => [
        'id' => ['=', $id],
      ],
    ]);
  }

}