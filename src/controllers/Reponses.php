<?php

namespace App\Controllers;

class Reponses {
  protected array $params;
  protected string $reqMethod;

  public function __construct($params) {
    $this->params = $params;
    $this->reqMethod = strtolower($_SERVER['REQUEST_METHOD']);

    $this->run();
  }

  public function getReponse() {
    $reponses = [
        2 => "help blabla commande", // help
        3 => "Pokemon est sortie le 27 Février 1996.", // date
        4 => "La première région de Pokemon est Kanto !", // region
        5 => "Satoshi est le nom japonais de Sacha." // nom
    ];

    $id = intval($this->params['id']);

    if (array_key_exists($id, $reponses)) {
      return $reponses[$id];
    } else {
      header('HTTP/1.0 404 Not Found');
      return json_encode([
        'code' => '404',
        'message' => 'Not Found'
      ]);
    }
  }

  public function hello() {
    $response = "Bip Bop, bonjour humain !";
    echo $response;
  }  

  protected function header() {
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json; charset=utf-8');
  }

  protected function ifMethodExist() {
    $method = $this->reqMethod.'Reponse';

    if (method_exists($this, $method)) {
      $response = $this->$method();

      if (is_array($response)) {

        echo json_encode($response);
      } else {

        echo $response;
      }
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