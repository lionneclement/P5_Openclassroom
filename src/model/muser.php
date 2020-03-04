<?php

namespace App\model;

use App\model\connect;

class muser extends connect
{
  public function check($email)
  {
    return $this->bdd->query("SELECT * FROM user WHERE email='".$email."'"); 
  }
  public function register($post)
  {
    $sql = 'INSERT INTO user (id, nom, prenom, email, mdp, role_id) 
    VALUES (NULL,:nom,:prenom,:email,:mdp,1)';
    $this->bdd->prepare($sql)->execute($post);
  }
  public function roles($id)
  {
    return $this->bdd->query('SELECT * FROM user WHERE NOT id='.$id.''); 
  }
  public function updaterole($post)
  {
    $sql = 'UPDATE user SET role_id=:role_id WHERE id=:id';
    $this->bdd->prepare($sql)->execute($post);
  }
  public function allcomment()
  {
    return $this->bdd->query('SELECT * FROM commentaire');
  }
  public function updatecomment($post)
  {
    $sql = 'UPDATE commentaire SET statut=:statut WHERE id=:id';
    $this->bdd->prepare($sql)->execute($post);
  }
  public function invalidecomment()
  {
    return $this->bdd->query('SELECT * FROM commentaire WHERE statut=0');
  }
}