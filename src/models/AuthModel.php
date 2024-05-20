<?php

namespace App\Models;

use \PDO;
use stdClass;

class AuthModel extends SqlConnect
{

  public function login(string $mail, string $password)
  {
    $req = $this->db->prepare("SELECT * FROM users WHERE mail = :mail");
    $req->execute(["mail" => $mail]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    if (!$user or !password_verify($password, $user['password'])) {
      return json_encode($user);
    }

    return new stdClass();
  }

  public function register(array $data)
  {
    $name = $data['name'];
    $mail = $data['mail'];
    $password = $data['password'];

    $checkEmailQuery = "SELECT COUNT(*) FROM users WHERE mail = :mail";
    $checkEmailResponse = $this->db->prepare($checkEmailQuery);
    $checkEmailResponse->execute([':mail' => $mail]);

    if ($checkEmailResponse->fetchColumn() === 0) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $query = "INSERT INTO users (name, mail, password) VALUES (:name, :mail, :password)";
      $response = $this->db->prepare($query);
      $response->execute([
        ':name' => $data['name'],
        ':mail' => $data['mail'],
        ':password' => $hashedPassword,
      ]);

      
      $_SESSION['name'] = $name;
      $_SESSION['isLog'] = true;



      return ['success' => true, 'message' => 'User registered successfully'];
    } else {
      return ['success' => false, 'message' => 'Email already exists'];
    }
  }

  public function logout()
  {
    if (session_status() !== PHP_SESSION_NONE) {
      session_unset($_SESSION);
      return ['success' => true, 'message' => 'Session unset successfully'];
    } else {
      return ['success' => false, 'message' => "la session ne peut pas etre detruite elle existe pas"];
    }
  }
}
