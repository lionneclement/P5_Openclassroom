<?php

namespace App\model;

use App\model\connectmodel;

class postmodel extends connectmodel
{
  public function posts()
  {
    return $this->bdd->query('SELECT * FROM article');
  }
  public function post(entity $post)
  {
   return $this->bdd->query('SELECT * FROM article WHERE id='.$post->getarticle_id().'');
  }
  public function add(entity $post)
  {
    $sql = 'INSERT INTO article (id, titre, chapo, contenu, date, user_id) 
    VALUES (NULL,:titre,:chapo,:contenu, CURRENT_TIMESTAMP,:user_id)';
    $this->bdd->prepare($sql)->execute(array('titre'=>$post->gettitre(),'chapo'=>$post->getchapo(),'contenu'=>$post->getcontenu(),'user_id'=>$post->getuser_id()));
  }
  public function update(entity $post)
  {
    $sql = 'UPDATE article SET titre=:titre, chapo=:chapo, contenu=:contenu, date=CURRENT_TIMESTAMP, user_id=:user_id WHERE id=:id';
    $this->bdd->prepare($sql)->execute(array('titre'=>$post->gettitre(),'chapo'=>$post->getchapo(),'contenu'=>$post->getcontenu(),'user_id'=>$post->getuser_id(),'id'=>$post->getid()));
  }
  public function remove(entity $post)
  {
    $this->bdd->query('DELETE FROM commentaire WHERE article_id='.$post->getarticle_id().'');
    $this->bdd->query('DELETE FROM article WHERE id='.$post->getarticle_id().'');
  }
  public function allcomment(entity $post)
  {
    return $this->bdd->query('SELECT * FROM commentaire WHERE article_id='.$post->getarticle_id().' AND statut=1');
  }
  public function addcomment(entity $post)
  {
    $sql = 'INSERT INTO commentaire (id, message, statut, date, user_id, article_id) 
    VALUES (NULL,:message,0,CURRENT_TIMESTAMP,:user_id,:article_id)';
    $this->bdd->prepare($sql)->execute(array('message'=>$post->getmessage(),'user_id'=>$post->getuser_id(),'article_id'=>$post->getarticle_id()));
  }
}