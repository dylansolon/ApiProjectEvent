<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\AuthModel;

class Auth extends Controller
{

  protected object $model;

  public function __construct($param)
  {
    $this->model = new AuthModel();

    parent::__construct($param);
  }

  // public function getAuth()
  // {
  //   if (session_status() === PHP_SESSION_NONE) {
  //     session_start();

  //     header('HTTP/1.0 201 Created');
  //     return [
  //       'code' => '201',
  //       'message' => 'Session Created'
  //     ];
  //   }

  //   header('HTTP/1.0 401 Unauthorized');
  //   return [
  //     'code' => '401',
  //     'message' => 'Session Unauthorized'
  //   ];
  // }
  public function getAuth()
  {
    session_start();

    if (isset($_SESSION['isLog']) && $_SESSION['isLog'] === true) {
      header('HTTP/1.0 201 Created');
      return [
        'code' => '201',
        'message' => 'Session Created'
      ];
    }

    header('HTTP/1.0 401 Unauthorized');
    return [
      'code' => '401',
      'message' => 'Session Unauthorized'
    ];
  }


  public function postAuth()
  {

    if (isset($this->body["action"])) {
      $action = $this->body["action"];


      if ($action === 'login') {

        $user = $this->model->login($this->params['id']);

        if (isset($_COOKIE["PHPSESSID"]) && $_COOKIE["PHPSESSID"] === $user["sessionId"]) {
          header('HTTP/1.0 200 OK');
          echo json_encode([
            'code' => '200',
            'message' => 'Session OK'
          ]);
        } else {
          header('HTTP/1.0 401 Unauthorized');
          echo json_encode([
            'code' => '401',
            'message' => 'Session Unauthorized'
          ]);
        }
      } elseif ($action === 'register') {
 
        $result = $this->model->register($this->body);

        if ($result['success'] === true) {
          header('HTTP/1.0 201 Created');
          return [
            'code' => '201',
            'message' => $result['message']
          ];
        } else {
          header('HTTP/1.0 400 Bad Request');
          return [
            'code' => '400',
            'message' => $result['message']
          ];
        }
      } elseif ($action === 'logout') {

        $result = $this->model->logout($this->body);

        if ($result['success'] === true) {
          header('HTTP/1.0 201 Session Destroyed');
          return [
            'code' => '201',
            'message' => $result['message']
          ];
        } else {
          header("HTTP/1.0 400 Session doesn't exist");
          return [
            'code' => '400',
            'message' => $result['message']
          ];
        }

      } else {
        // Si l'action n'est ni 'login' ni 'register', renvoyer une erreur 400
        header('HTTP/1.0 400 Bad Request1');
        return [
          'code' => '400',
          'message' => 'Invalid action'
        ];
      }
    } else {
      // Si l'action n'est pas définie, renvoyer une erreur 400
      header('HTTP/1.0 400 Bad Request2');
      return [
        'code' => '400',
        'message' => 'Action not specified'
      ];
    }
  }
}