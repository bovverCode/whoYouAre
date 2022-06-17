<?php

namespace Who\Controller\admin;

use Who\Controller\BaseController;
use Who\Controller\traits\ContextController;

class AuthController extends BaseController {

  use ContextController;

  /**
   * {@inheritdoc}
   */
  protected function build() {
    // Redirect to index admin page if logged in
    if (isset($_SESSION['auth'])) {
      header('Location: /admin');
    }
    // request method
    $method = $this->routeController->get('requestMethod');
    if ($method === 'POST') {
      list($errors, $inputs) = $this->validateForm($_POST);
      if ($errors) {
        $this->baseView->buildPage('user', ['header'=> '']);
        $this->baseView->buildPage('admin', ['auth'=> ['errors' => $errors]]);
        $this->baseView->buildPage('user', ['footer'=> '']);
      } else {
        $error = $this->submitForm($inputs);
        $this->baseView->buildPage('user', ['header'=> '']);
        $this->baseView->buildPage('admin', ['auth'=> ['errors' => [$error]]]);
        $this->baseView->buildPage('user', ['footer'=> '']);
      }
    } else {
      // GET
      $this->baseView->buildPage('user', ['header'=> '']);
      $this->baseView->buildPage('admin', ['auth'=> '']);
      $this->baseView->buildPage('user', ['footer'=> '']);
    }
  }

  /**
   * Method validate auth form.
   * $data - array of POST data.
   */
  protected function validateForm($data) {
    $errors = [];
    $inputs = [];

    $inputs['name'] = trim($data['name']);
    if (!$inputs['name']) {
      $errors[] = 'Name is required.';
    }

    $inputs['password'] = trim($data['password']);
    if (!$inputs['password']) {
      $errors[] = 'Password is required.';
    }

    return [$errors, $inputs];
  }

  /**
   * Method submit auth form.
   * $inputs - array of form data.
   */
  protected function submitForm($inputs) {
    $error = 'Incorrect credentials.';
    $name = $inputs['name'];
    $password = $inputs['password'];

    // Try to find user with the $name.
    $result = $this->baseModel->read('user', [
      'fields' => ['password'],
      'where' => ['name' => ['=', $name]],
    ]);
    if (!empty($result)) {
      $row = reset($result);
      // check password match
      $passwordMatch = password_verify($password, $row['password']);
      if ($passwordMatch) {
        // make user logged in
        $_SESSION['auth'] = true;
        header('Location: /admin');
      }
    }
    return $error;
  }

}