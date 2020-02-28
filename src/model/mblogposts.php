<?php

namespace App\controller;

class mblogposts
{
  public function connect()
  {
      try {
        $bdd = new \PDO('mysql:host=localhost;dbname=p5', 'root', '');
        return $bdd->query('SELECT * FROM user');
       } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
      }
  }
}