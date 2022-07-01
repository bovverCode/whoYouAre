<?php

namespace Who\Service\Logger;

use PDO;
use Who\Controller\traits\Singleton;
use Who\Model\BaseModel;

/**
 * Base Logger class.
 */
class Base {

  use Singleton;

  /**
   * Logger table name.
   *
   * @var string
   */
  protected $table = 'log';

  /**
   * Logger table columns.
   *
   * @var string[]
   */
  protected $fields = ['type', 'text', 'time'];

  /**
   * Log count on page.
   *
   * @var int
   */
  protected $logsOnPage = 10;

  /**
   * @var BaseModel
   */
  protected $baseModel;

  /**
   * {@inheritdoc}
   */
  protected function __construct() {
    $this->baseModel = BaseModel::getInstance();
  }

  /**
   * Write log function.
   * Return true if successfully created.
   *
   * @param int $type
   *  Log type
   * @param string $text
   *  Log text
   */
  public function log($type, $text) {
    # Insert log to db.
    $time = date('m/d/Y h:i:s a', time());
    return $this->baseModel->create($this->table, $this->fields, [$type, $text, $time]);
  }

  /**
   * Function returns array of logs or false if logs not exist in the page.
   *
   * @param int $page
   *  Page number.
   * @return array
   */
  public function getLogs($page = 1) {
    # Logs limit.
    $start = $page <= 1 ? 0 : ($page - 1) * 10;
    $quantity = 10;

    return $this->baseModel->read($this->table, [
    'sort' => ['id' => 'DESC'],
    'limit' => [$start, $quantity],
    ]);
  }

  /**
   * Get total logs quantity.
   *
   * @return mixed
   */
  public function getTotalCount() {
    $count = $this->baseModel->query("SELECT COUNT(*) FROM {$this->table}", [], PDO::FETCH_NUM);
    return $count[0][0];
  }

}