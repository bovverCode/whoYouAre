<?php

namespace Who\Service;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Who\Controller\traits\Singleton;

/**
 * Class provides methods and values to handle services.
 */
class ServiceHandler {

  use Singleton;

  /**
   * Array of links for services.
   *
   * @var array
   */
  protected $services = [];

  /**
   * {@inheritdoc}
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static();

      # Parse service settings file.
      try {
        $services = Yaml::parse(file_get_contents(SERVICE_SETTINGS));
      } catch (ParseException $e) {
        exit($e->getMessage());
      }

      # Setting services array.
      $services = reset($services);
      if (is_array($services)) {
        foreach ($services as $name => $path) {
          self::$instance->services[$name] = $path;
        }
      }
      return self::$instance;
    }
    return self::$instance;
  }

  /**
   * Function return services array.
   */
  public function getServices() {
    return $this->services;
  }

  /**
   * Function find and return instance of needle service.
   *
   * @param string $name
   */
  public function getService($name) {
    if (array_key_exists($name, $this->services)) {
      if (is_string($this->services[$name])) {
        # Create instance of needle service.
        $className = SERVICE_PATH . $this->services[$name];
        if (class_exists($className)) {
          // Create instance if not exist.
          return $this->services[$name] = $className::getInstance();
        } else {
          throw new \Exception('Class: ' . $className . ' not exist.');
        }
      } else {
        # Return class instance if already exist.
        return $this->services[$name];
      }
    }
    return false;
  }

}