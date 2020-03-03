<?php
namespace App\controller;

use App\twig\twigenvi;

class home extends twigenvi
{
  private $usercookie;

  public function __construct()
  {
    parent::__construct();
    if (isset($_COOKIE['role'])){
      $this->usercookie['role'] = $_COOKIE['role'];
    }
    
  }
  public function accueil()
  {
    echo $this->twigenvi->render('/templates/home.html.twig',['access'=>$this->usercookie['role']]);
  }
}