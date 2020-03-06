<?php

namespace App\model;

use App\model\connectmodel;

class adminmodel extends connectmodel
{
  public function check(entity $post)
  {
    return $this->bdd->query("SELECT * FROM user WHERE email='".$post->getemail()."'"); 
  }
  public function register(entity $post)
  {
    $sql = 'INSERT INTO user (id, nom, prenom, email, mdp, role_id) 
    VALUES (NULL,:nom,:prenom,:email,:mdp,1)';
    $this->bdd->prepare($sql)->execute(array('nom'=>$post->getnom(),'prenom'=>$post->getprenom(),'email'=>$post->getemail(),'mdp'=>$post->getmdp()));
  }
  public function roles(entity $post)
  {
    return $this->bdd->query('SELECT * FROM user WHERE NOT id='.$post->getuser_id().''); 
  }
  public function updaterole(entity $post)
  {
    $sql = 'UPDATE user SET role_id=:role_id WHERE id=:id';
    $this->bdd->prepare($sql)->execute(array('role_id'=>$post->getrole_id(),'id'=>$post->getid()));
  }
  public function allcomment()
  {
    return $this->bdd->query('SELECT * FROM commentaire');
  }
  public function updatecomment(entity $post)
  {
    $sql = 'UPDATE commentaire SET statut=:statut WHERE id=:id';
    $this->bdd->prepare($sql)->execute(array('statut'=>$post->getstatut(),'id'=>$post->getid()));
  }
  public function invalidecomment()
  {
    return $this->bdd->query('SELECT * FROM commentaire WHERE statut=0');
  }
  public function deletecomment(entity $post)
  {
    $this->bdd->query('DELETE FROM commentaire WHERE id='.$post->getid().'');
  }
  public function getpost(entity $post)
  {
   return $this->bdd->query('SELECT * FROM article WHERE user_id='.$post->getuser_id().'');
  }
  public function deleteuser(entity $post)
  {
    $this->bdd->query('DELETE FROM user WHERE id='.$post->getid().'');
  }
}