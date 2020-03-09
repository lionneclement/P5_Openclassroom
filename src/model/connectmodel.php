<?php

namespace App\model;

class connectmodel 
{
  protected $bdd;
  public function __construct()
  {
    try {
      $this->bdd = new \PDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'),getenv('DB_USER'),getenv('DB_PASSWORD'));
     } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
  }
}