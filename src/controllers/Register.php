<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\UserModel;

class Register extends Controller
{
  protected object $user;

  public function __construct($param)
  {
    $this->user = new UserModel();
    parent::__construct($param);
  }

  public function postRegister()
  {
    if ($this->user->create($this->body)) {

      session_start();
      $sessionId = session_id();

      header('HTTP/1.0 201 Created');
      return [
        'name' => $this->body['name'],
        'message' => $sessionId
      ];
    } else {
      header('HTTP/1.0 400 Bad Request');
      return [
        'code' => '400',
        'message' => 'User already exists or creation failed.'
      ];
    }
  }
}
