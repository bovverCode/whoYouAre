<?php

/**
 * Base functionality for fields service.
 * Service provides functionality to crud fields and fields group.
 */

namespace Who\Service\Fields;

use Who\Controller\traits\Singleton;
use Who\Model\BaseModel;

/**
 * Base class for fields service.
 */
class Base {

  use Singleton;

  /**
   * Fields table name.
   *
   * @var string
   */
  private string $fields_table = 'field';

  /**
   * Fields groups table name.
   *
   * @var string
   */
  private string $fields_groups_table = 'field_group';

  /**
   * Default field types.
   *
   * @var array|string[]
   */
  private array $field_types = ['text', 'image'];

  /**
   * BaseModel class instance.
   *
   * @var BaseModel
   */
  protected BaseModel $baseModel;

  /**
   * Field class instance.
   *
   * @var Field
   */
  public Field $field;

  /**
   * FieldGroup class instance.
   *
   * @var FieldGroup
   */
  public FieldGroup $group;

  /**
   * {@inheritdoc}
   */
  protected function __construct() {
    $this->baseModel = BaseModel::getInstance();
    $this->group = FieldGroup::getInstance($this->baseModel, $this->fields_groups_table);
    $this->field = Field::getInstance($this->baseModel, $this->fields_table, $this->field_types);
  }

  public function getFieldsByGroup(int $group_id) : array {
    return $this->baseModel->read($this->fields_table, [
      'where' => ['group_id' => ['=', $group_id]],
      'sort' => ['id' => 'ASC'],
    ]);
  }

  /**
   * Get field types.
   *
   * @return array|string[]
   */
  public function getFieldTypes() {
    return $this->field_types;
  }

}