<?php

/**
 * Additional logic for some actions of fields service.
 */

namespace Who\Service\Fields;

use Who\Controller\traits\Singleton;

/**
 * Events class contains handlers for different fields service events.
 */
class Events {

  use Singleton;

  /**
   * Handle type change of field schema.
   *
   * @param int $schema_id
   *   Schema ID.
   * @param string $new_type
   *   New type of schema.
   *
   * @return void
   */
  public function changeSchemaType(int $schema_id, string $new_type) {
    // do something
  }

  /**
   * Handle remove of field schema.
   *
   * @param int $id
   * Schema ID.
   *
   * @return void
   */
  public function removeSchema(int $id) {
    // do something
  }

}