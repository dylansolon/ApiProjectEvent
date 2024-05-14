<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\AuthentificationModel;

class Authentification extends Controller
{
  protected array $params;
  protected string $reqMethod;
  protected object $model;

  public function __construct($param)
  {
    $this->model = new AuthentificationModel();

    parent::__construct($param);
  }

  public function postAuthentification()
  {
    $body = (array) json_decode(file_get_contents('php://input'));

    return $this->model->compareLog($body);
  }

  // protected function run()
  // {
  //   $this->header();
  //   $this->ifMethodExist();
  // }
}
