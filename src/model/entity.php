<?php

namespace App\model;

class entity
{
  private $_id;
  private $_titre;
  private $_chapo;
  private $_contenu;
  private $_message;
  private $_statut;
  private $_nom;
  private $_prenom;
  private $_email;
  private $_mdp;
  private $_role_id;
  private $_user_id;
  private $_article_id;

  public function __construct(array $data =[])
  {
    if (!empty($data)) {
        $this->hydrate($data);
      }
  }

  public function hydrate(array $donnees)
  {
    foreach ($donnees as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method))
      {
        $this->$method($value);
      }
    }
  }

  public function getid(){return $this->_id;}
  public function gettitre(){return $this->_titre;}
  public function getchapo(){return $this->_chapo;}
  public function getcontenu(){return $this->_contenu;}
  public function getmessage(){return $this->_message;}
  public function getstatut(){return $this->_statut;}
  public function getnom(){return $this->_nom;}
  public function getprenom(){return $this->_prenom;}
  public function getemail(){return $this->_email;}
  public function getmdp(){return $this->_mdp;}
  public function getrole_id(){return $this->_role_id;}
  public function getuser_id(){return $this->_user_id;}
  public function getarticle_id(){return $this->_article_id;}

  public function setId($id)
  {
    $id = (int) $id;
    if ($id > 0)
    {
      $this->_id = $id;
    }
  }
  public function setTitre($titre){
    if (is_string($titre) && strlen($titre) <= 30)
    {
      $this->_titre = $titre;
    }
  }
  public function setChapo($chapo){
    if (is_string($chapo) && strlen($chapo) <= 255)
    {
      $this->_chapo = $chapo;
    }
  }
  public function setContenu($contenu){
    if (is_string($contenu))
    {
      $this->_contenu = $contenu;
    }
  }
  public function setMessage($message){
    if (is_string($message) && strlen($message) <= 255)
    {
      $this->_message = $message;
    }
  }
  public function setStatut($statut)
  {
    $statut = (int) $statut;
    if ($statut == 0 || $statut == 1)
    {
      $this->_statut = $statut;
    }
  }
  public function setNom($nom){
    if (is_string($nom) && strlen($nom) <= 30)
    {
      $this->_nom = $nom;
    }
  }
  public function setPrenom($prenom){
    if (is_string($prenom) && strlen($prenom) <= 30)
    {
      $this->_prenom = $prenom;
    }
  }
  public function setEmail($email){
  if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $this->_email = $email;
    }
  }
  public function setMdp($mdp){
  if (is_string($mdp))
    {
      $this->_mdp = password_hash($mdp, PASSWORD_DEFAULT);
    }
  }
  public function setRole_id($role_id){
    $role_id = (int) $role_id;
    if ($role_id >= 1 && $role_id <= 3)
    {
      $this->_role_id = $role_id;
    }
  }
  public function setUser_id($user_id){
    $user_id = (int) $user_id;
    if ($user_id >= 1)
    {
      $this->_user_id = $user_id;
    }
  }
  public function setArticle_id($article_id){
    $article_id = (int) $article_id;
    if ($article_id >= 1)
    {
      $this->_article_id = $article_id;
    }
  }
}