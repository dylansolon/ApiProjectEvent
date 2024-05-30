<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\EventModel;

class Event extends Controller
{

  protected object $model;

  public function __construct($param)
  {
    $this->model = new EventModel();

    parent::__construct($param);
  }

  public function postEvent()
  {

    $result = $this->model->addEvent($this->body);

    if ($result['success'] === true) {
      header('HTTP/1.0 201 Created');
      echo json_encode([
        'code' => '201',
        'message' => $result['message']
      ]);
    } else {
      header('HTTP/1.0 400 Bad Request');
      echo json_encode([
        'code' => '400',
        'message' => $result['message']
      ]);
    }
  }

}