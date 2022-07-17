<?php

/**
 * Base functionality for fields service.
 * Service provides functionality to crud fields and field groups.
 */

namespace Who\Service\Fields;

use Who\Controller\traits\Singleton;
use Who\Model\BaseModel;
use Who\Service\Fields\Model\FieldSchema;
use Who\Service\Fields\Model\Group;

/**
 * Base class for fields service.
 */
class Base {

  use Singleton;

  /**
   * Field groups table name.
   *
   * @var string
   */
  private string $group_table = 'fields_group';

  /**
   * Fields schema table name.
   *
   * @var string
   */
  private string $schema_table = 'fields_schema';

  /**
   * Fields schema relation table name.
   *
   * @var string
   */
  private string $schema_relation_table = 'fields_schema_relation';

  /**
   * Primitive fields table name.
   *
   * @var string
   */
  private string $primitive_table = 'fields_primitive';

  /**
   * Reference fields table name.
   *
   * @var string
   */
  private string $reference_table = 'fields_reference';

  /**
   * Reference and primitive fields relation table name.
   *
   * @var string
   */
  private string $reference_primitive_relation_table = 'fields_ref_prim_relation';

  /**
   * Default field types.
   *
   * @var array|string[]
   */
  private array $field_types = ['text', 'image', 'repeater'];

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
   * Group class instance.
   *
   * @var Group
   */
  public Group $group;

  /**
   * Field schema class instance.
   *
   * @var FieldSchema
   */
  public FieldSchema $schema;

  /**
   * {@inheritdoc}
   */
  protected function __construct() {
    $this->baseModel = BaseModel::getInstance();
    $this->events = Events::getInstance();
    $this->group = Group::getInstance($this->baseModel, $this->group_table);
    $this->schema = FieldSchema::getInstance($this->baseModel, $this->schema_table, $this->events);
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