<?php

namespace App\controller;

class mpost
{
  private $bdd ='';
  public function __construct()
  {
    try {
      $this->bdd = new \PDO('mysql:host=localhost;dbname=p5', 'root', '');
     } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
  }
  public function posts()
  {
    return $this->bdd->query('SELECT * FROM article');
  }
  public function post($id)
  {
    return $this->bdd->query('SELECT * FROM article WHERE id='.$id.'');
  }
}