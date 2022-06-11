<?php
/**
 * File contains basic model class.
 */

namespace Who\Model;

use PDO;
use Who\Controller\traits\Singleton;

class BaseModel {

  use Singleton;

  /**
   * @var $db PDO
   * Database connection;
   */
  protected $db;

  /**
   * {@inheritdoc}
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static();
      self::$instance->db = $dbh = new PDO('mysql:host=' . HOST_NAME . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
      return self::$instance;
    }
    return self::$instance;
  }

  /**
   * Execute some query
   */
  public function query($query) {
    return $this->db->query($query);
  }

  /**
   * Read database function.
   * $options could be an array like:
   * [
   *  'fields' => ['id', 'name'],
   *  'where' => ['age' => ['>','18']],
   *  'sort' => ['name' => 'ASC']
   * ]
   */
  public function read($table, $options = []) {
    $query = "SELECT";

    # Getting fields for our query.
    $fields = '';
    if ($options['fields']) {
      if (is_array($options['fields'])) {
        foreach ($options['fields'] as $field) {
          $fields .= $table . '.' . $field . ',';
        }
        $fields = rtrim($fields, ',');
      } else {
        $fields = $table . '.' . $options['fields'];
      }
    } else $fields = '*';

    # Getting where conditions.
    $where = '';
    if ($options['where'] && is_array($options['where'])) {
      $where = 'WHERE';
      foreach ($options['where'] as $field => $value) {
        if (is_string($value[1])) {
          $where .= " $table.$field{$value[0]}'{$value[1]}' AND";
        } else {
          $where .= " $table.$field{$value[0]}{$value[1]} AND";
        }
      }
      $where = rtrim($where, 'AND');
    }

    # Getting sort stuff.
    $sort = '';
    if ($options['sort'] && is_array($options['sort'])) {
      $sort = 'ORDER BY ' ;
      foreach ($options['sort'] as $field => $rule) {
        $sort .= "$field $rule,";
      }
      $sort = rtrim($sort, ',');
    }

    $query .= " $fields FROM $table $where $sort";
    return $this->query($query);
  }

  /**
   * Insert row(s) in table.
   * $fields contains an array of field names.
   * $values contains an array with values for fields.
   */
  public function create($table, $fields, $values) {
    $query = 'INSERT INTO ' . DB_NAME . '.' . $table;

    # Getting field names.
    $names = '';
    if ($fields && is_array($fields)) {
      $names = '(';
      foreach ($fields as $field) {
        $names .= "$field, ";
      }
      $names = rtrim($names, ', ') . ')';
    }

    # Getting field values.
    $cols = '';
    if ($values && is_array($values)) {
      $cols = 'VALUES (';
      foreach ($values as $value) {
        if (is_string($value)) {
          $cols .= "'$value',";
        } else {
          $cols .= "$value,";
        }
      }
      $cols = rtrim($cols, ',') . ')';
    }

    $query .= " $names $cols";
    return $this->query($query);
  }

}