<?php
namespace App\mail;

class email
{
  private $nom='';
  private $prenom='';
  private $email='';
  private $message='';

  public function __construct($post)
  { 
      $this->nom = $post['nom'];
      $this->prenom = $post['prenom'];
      $this->email = $post['email'];
      $this->message = $post['message'];
  }
  public function send()
  {
    mail($this->email,$this->prenom.' '.$this->nom,$this->message);
  }
}