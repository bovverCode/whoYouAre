<?php

/**
 * Class implements functionality to manage field schemas.
 */

namespace Who\Service\Fields\Model;

use Who\Controller\traits\Singleton;
use Who\Model\BaseModel;
use Who\Service\Fields\Events;

/**
 * Field schema class.
 */
class FieldSchema {

  use Singleton;

  /**
   * Fields schema table name.
   *
   * @var string
   */
  private string $table;

  /**
   * BaseModel class instance.
   *
   * @var BaseModel
   */
  protected BaseModel $baseModel;

  /**
   * Events class instance.
   *
   * @var Events
   */
  protected Events $events;

  /**
   * {@inheritdoc}
   */
  public static function getInstance(BaseModel $baseModel, string $table, Events $events) {
    if (!isset(self::$instance)) {
      self::$instance = new static();
      self::$instance->baseModel = $baseModel;
      self::$instance->table = $table;
      self::$instance->events = $events;
      return self::$instance;
    }
    return self::$instance;
  }

  /**
   * Create field schema.
   *
   * @param string $slug
   *  Slug of field.
   * @param string $type
   *  Type of field.
   * @param int $group_id
   *  ID of field group.
   *
   * @return void
   */
  public function createSchema(string $slug, string $type, int $group_id) {
    $this->baseModel->create($this->table, ['slug', 'type', 'group_id'], [$slug, $type, $group_id]);
  }

  /**
   * Update field schema slug.
   *
   * @param int $id
   *  ID of field schema.
   * @param string $new_slug
   *  New slug og field schema.
   *
   * @return void
   */
  public function updateSchemaSlug(int $id, string $new_slug) {
    $this->baseModel->update($this->table, [
      'fields' => [
        'slug' => $new_slug
      ],
      'where' => [
        'id' => ['=', $id],
      ],
    ]);
  }

  /**
   * Update field schema type.
   *
   * @param int $id
   *  ID of schema field.
   * @param string $new_type
   *  New type of schema field.
   *
   * @return void
   */
  public function updateSchemaType(int $id, string $new_type) {
    $this->events->changeSchemaType($id, $new_type);
    $this->baseModel->update($this->table, [
      'fields' => [
        'type' => $new_type
      ],
      'where' => [
        'id' => ['=', $id],
      ],
    ]);
  }

  /**
   * Get field schemas by group ID.
   *
   * @param int $group_id
   *  Group ID.
   *
   * @return array
   */
  public function readSchemasByGroupId(int $group_id) : array {
    return $this->baseModel->read($this->table, [
      'where' => ['group_id' => ['=', $group_id]],
    ]);
  }

  /**
   * Remove schema by ID.
   *
   * @param int $id
   *  Fields schema ID.
   *
   * @return void
   */
  public function removeSchemaById(int $id) {
    $this->events->removeSchema($id);
    $this->baseModel->delete($this->table, [
      'where' => ['id' => ['=', $id]],
    ]);
  }

}