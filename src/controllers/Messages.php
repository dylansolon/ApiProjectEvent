<?php

namespace App\Controllers;

use App\Models\MessagesModel;

class Messages {
  protected array $params;
  protected string $reqMethod;
  protected object $model;

  public function __construct($params) {
    $this->params = $params;
    $this->reqMethod = strtolower($_SERVER['REQUEST_METHOD']);
    $this->model = new MessagesModel();

    $this->run();
  }

  public function getMessages() {
    return $this->model->getAll();
  }

  public function postMessages() {
    $body = (array) json_decode(file_get_contents('php://input'));

    return $this->model->add($body);

    return $this->model->getLast();
  }

  protected function header() {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers : Content-Type');
    header('Access-Control-Allow-Methods : PUT, DELETE, PATCH, POST, OPTIONS');
    header('Content-type: application/json; charset=utf-8');
    if ($this->reqMethod === "options") {
      header('Access-Control-Max-Age : 86400');
      exit;
    }
  }

  protected function ifMethodExist() {
    $method = $this->reqMethod.'Messages';

    if (method_exists($this, $method)) {
      header('HTTP/1.0 200 OK');
      echo json_encode($this->$method());

      return;
    }

    header('HTTP/1.0 404 Not Found');
    echo json_encode([
      'code' => '404',
      'message' => 'Not Found'
    ]);

    return;
  }

  protected function run() {
    $this->header();
    $this->ifMethodExist();
  }
}
