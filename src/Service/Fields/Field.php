<?php

/**
 * Part of fields plugin.
 * Implementation of field functionality.
 */

namespace Who\Service\Fields;

use Who\Controller\traits\Singleton;
use Who\Model\BaseModel;

/**
 * Field functionality class.
 */
class Field {

  use Singleton;

  /**
   * BaseModel class instance.
   *
   * @var BaseModel
   */
  protected BaseModel $baseModel;

  /**
   * Field table name.
   *
   * @var string
   */
  protected string $table;

  /**
   * Default field types.
   *
   * @var array|string[]
   */
  private array $field_types;

  /**
   * {@inheritdoc}
   */
  public static function getInstance(BaseModel $baseModel, string $table, array $types) {
    if (!isset(self::$instance)) {
      self::$instance = new static();
      self::$instance->baseModel = $baseModel;
      self::$instance->table = $table;
      self::$instance->field_types = $types;
      return self::$instance;
    }
    return self::$instance;
  }

  use Singleton;

  /**
   * Create field.
   *
   * @param string $name
   *   Field slug.
   *
   * @param string $value
   *   Field value.
   *
   * @param string $type
   *   Field type.
   *
   * @param int $groupID
   *   Field group id.
   *
   * @param string $file_path
   *   File path for image.
   *
   * @return void
   */
  public function createField(string $name, string $value, string $type, int $groupID, string $file_path = '') {
    if ($type === 'text') {
      # Create text field.
      $this->baseModel->create($this->table,
        ['key', 'value', 'type', 'group_id'],
        [$name, $value, $type, $groupID]
      );
    } else {
      # Create image field, in this case $value is file tmp name.
      move_uploaded_file($value, $file_path);
    }
  }

  public function updateField() {

  }

  public function removeField() {

  }

}