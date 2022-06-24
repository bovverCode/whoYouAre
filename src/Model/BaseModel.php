<?php
/**
 * File contains basic model class.
 */

namespace Who\Model;

use PDO;
use PDOException;
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
      // Try to create connection with db.
      try {
        self::$instance->db = new PDO('mysql:host=' . HOST_NAME . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
      } catch (PDOException $e) {
        exit("DB Error: " . $e->getMessage());
      }
      return self::$instance;
    }
    return self::$instance;
  }

  /**
   * Execute some query
   */
  public function query($query, $values = []) {
    try {
      $stmt = $this->db->prepare($query);
      $stmt->execute($values);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      exit("DB Error: " . $e->getMessage());
    }
  }

  /**
   * Read database function.
   * $options could be an array like:
   * [
   *  'fields' => ['id', 'name'],
   *  'where' => ['age' => ['>', 18]],
   *  'sort' => ['name' => 'ASC']
   * ]
   */
  public function read($table, $options = []) {
    $query = "SELECT";
    $prepareValues = [];

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
    $where = $this->where($table, $options, $prepareValues);

    # Getting sort stuff.
    $sort = '';
    if (isset($options['sort']) && is_array($options['sort'])) {
      $sort = 'ORDER BY ' ;
      foreach ($options['sort'] as $field => $rule) {
        $sort .= "$field $rule,";
      }
      $sort = rtrim($sort, ',');
    }

    $query .= " $fields FROM $table $where $sort";
    return $this->query($query, $prepareValues);
  }

  /**
   * Insert row in table.
   * $fields contains an array of field names.
   * $values contains an array with values for fields.
   */
  public function create($table, $fields, $values) {
    $query = 'INSERT INTO ' . DB_NAME . '.' . $table;
    $prepareValues = [];

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
        $cols .= "?,";
        $prepareValues[] = $value;
      }
      $cols = rtrim($cols, ',') . ')';
    }

    $query .= " $names $cols";
    return $this->query($query, $prepareValues);
  }

  /**
   * Update table row function.
   * $options is an array of arrays like:
   * [
   *  'fields' => [
   *    'name' => 'Kate'
   *    'age' => 52,
   *    'job' => 'Manager'
   *  ],
   *  'where' => ['id' => ['=', 5]],
   * ]
   */
  public function update($table, $options) {
    $query = "UPDATE $table";
    $prepareValues = [];

    # Getting values to set.
    $set = '';
    if ($options['fields'] && is_array($options['fields'])) {
      $set = 'SET ';
      foreach ($options['fields'] as $name => $value) {
        $set .= "$table.$name=?,";
        $prepareValues[] = $value;
      }
      $set = rtrim($set, ',');
    }

    # Getting where conditions.
    $where = $this->where($table, $options, $prepareValues);

    $query .= " $set $where";
    return $this->query($query, $prepareValues);
  }

  /**
   * Delete table row(s) function.
   * $options is an array of arrays like:
   * [
   *  'where' => ['id' => ['=', 5]],
   * ]
   */
  public function delete($table, $options) {
    $query = "DELETE FROM $table";
    $prepareValues = [];

    # Getting where conditions.
    $where = $this->where($table, $options, $prepareValues);

    $query .= " $where";
    return $this->query($query, $prepareValues);
  }

  /**
   * Function build where conditions for query.
   *
   * @var $table
   *  String name of table.
   * @var $options
   *  Array of query options.
   * @var $prepareValues
   *  Link for the query values array.
   */
  protected function where($table, $options, &$prepareValues) {
    $whereQuery = '';
    $where = $options['where'];

    if (is_array($where) && !empty($where)) {
      $whereQuery = 'WHERE';
      foreach ($where as $field => $value) {
        $whereQuery .= " $table.$field{$value[0]}? AND";
        $prepareValues[] = $value[1];
      }
      $whereQuery = rtrim($whereQuery, 'AND');
    }

    return $whereQuery;
  }

}