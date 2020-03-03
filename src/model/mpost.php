<?php

namespace App\model;

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
  public function add($post)
  {
    $sql = 'INSERT INTO article (id, titre, chapo, contenu, date, user_id) 
    VALUES (NULL,:titre,:chapo,:contenu, CURRENT_TIMESTAMP,:user_id)';
    $this->bdd->prepare($sql)->execute($post);
  }
  public function update($id,$post)
  {
    $post['id']=$id;
    var_dump($post);
    $sql = 'UPDATE article SET titre=:titre, chapo=:chapo, contenu=:contenu, date=CURRENT_TIMESTAMP, user_id=:user_id WHERE id=:id';
    $this->bdd->prepare($sql)->execute($post);
  }
  public function remove($id)
  {
    $array['id']=$id;
    $sql = 'DELETE FROM article WHERE id=:id';
    $this->bdd->prepare($sql)->execute($array);
  }
}