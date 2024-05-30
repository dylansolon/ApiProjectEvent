<?php

namespace App\Models;

use \PDO;
use stdClass;

class EventModel extends SqlConnect
{

  public function addEvent(array $data)
  {

      $query = "
          INSERT INTO events (orgName, title, img, startDate, startTime, endDate, endTime, description, location)
        VALUES (:orgName, :title, :img, :startDate, :startTime, :endDate, :endTime, :description, :location)
        ";
      $req = $this->db->prepare($query);
      $result = $req->execute($data);

      if ($result) {
        return ['success' => true, 'message' => 'Event added successfully'];
      } else {
        return ['success' => false, 'message' => 'An error occurred: '];
      }
    }
  }
