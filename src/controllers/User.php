<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\UserModel;

class User extends Controller{

  protected object $model;

  public function __construct($param)
  {
    $this->model = new UserModel();

    parent::__construct($param);
  }

  public function postUser()
  {
    $this->model->add($this->body);

    return $this->model->getLast();
  }

  public function deleteUser() {
    return $this->model->delete(intval($this->params['id']));
  }

  public function getUser() {
    return $this->model->get(intval($this->params['id']));
  }

}
