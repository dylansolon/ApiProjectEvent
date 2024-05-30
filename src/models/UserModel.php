<?php

namespace App\Models;

use \PDO;
use stdClass;

class UserModel extends SqlConnect
{

  public function login(array $data)
  {
    $mail = $data['mail'];
    $password = $data['password'];

    $req = $this->db->prepare("SELECT * FROM users WHERE mail = :mail");
    $req->execute(["mail" => $mail]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    /*     if (!$user || !password_verify($password, $user['password'])) {
      return false;
    } */

    return $user;
  }

  public function create(array $data): bool
  {
    $name = $data['name'];
    $mail = $data['mail'];
    $password = $data['password'];

    if (!$this->exists($mail)) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $query = "INSERT INTO users (name, mail, password) VALUES (:name, :mail, :password)";
      $response = $this->db->prepare($query);
      $response->execute([
        ':name' => $name,
        ':mail' => $mail,
        ':password' => $hashedPassword,
      ]);

      return true;
    }

    return false;
  }

  public function exists(string $mail): bool
  {
    $query = "SELECT COUNT(*) FROM users WHERE mail = :mail";
    $response = $this->db->prepare($query);
    $response->execute([':mail' => $mail]);

    return $response->fetchColumn() > 0;
  }
}
