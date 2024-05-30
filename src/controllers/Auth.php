<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\UserModel;

class Auth extends Controller
{

  protected object $user;

  public function __construct($param)
  {
    $this->user = new UserModel();

    parent::__construct($param);
  }

  public function postAuth()
  {

    $user = $this->user->login($this->body);

    if ($user) {

      session_start();

      $sessionId = session_id();

      http_response_code(200);

      return [
        'code' => '200',
        'message' => 'OK',
        'name' => $this->body['name'],
        'sessionId' => $sessionId
      ];
    }
    header('HTTP/1.0 401 Bad Request');

    return [
      'code' => '401',
      'message' => 'Unauthorized'
    ];
  }

  public function getAuth()
  {
    session_set_cookie_params(['samesite' => 'None']);
    session_start(['cookie_secure' => true, 'cookie_httponly' => true]);
    $providedSessionId = $this->params['sessionid'];

    if ($providedSessionId && $providedSessionId === session_id()) {
      header('HTTP/1.0 200 OK');
      return [
        'code' => '200',
        'message' => 'OK'
      ];
    }

    header('HTTP/1.0 401 Unauthorized');
    return [
      'code' => '401',
      'message' => 'Unauthorized'
    ];
  }
}
