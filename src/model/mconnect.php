<?php

namespace App\model;

class connect 
{
  protected $bdd;
  public function __construct()
  {
    try {
      $this->bdd = new \PDO('mysql:host=localhost;dbname=p5', 'root', '');
     } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
  }
}