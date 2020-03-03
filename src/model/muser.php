<?php

namespace App\model;

use App\model\connect;

class muser extends connect
{
  public function checkregister($post)
  {
    return $this->bdd->query("SELECT * FROM user WHERE email='".$post['email']."'"); 
  }
  public function checklogin($post)
  {
    return $this->bdd->query("SELECT * FROM user WHERE email='".$post['email']."' AND mdp='".$post['mdp']."' "); 
  }
  public function register($post)
  {
    $sql = 'INSERT INTO user (id, nom, prenom, email, mdp, role_id) 
    VALUES (NULL,:nom,:prenom,:email,:mdp,1)';
    $this->bdd->prepare($sql)->execute($post);
  }
}