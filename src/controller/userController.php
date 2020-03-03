<?php
namespace App\controller;

use App\twig\twigenvi;
use App\model\muser;

class user extends twigenvi
{
  private $modelpost;
  public function __construct()
  {
    parent::__construct();
    $this->modelpost = new muser;
  }
  public function register($post)
  {
    if(empty($post)){
      echo $this->twigenvi->render('/templates/user/register.html.twig');
    }else{
      $con = $this->modelpost->checkregister($post);
      $donnes = $con->fetchAll();
      if(empty($donnes)){
        $this->modelpost->register($post);
        echo 'user create';
      }else{
        echo 'already exits';
      }
    }
  }
  public function login($post)
  {
    if(empty($post)){
      echo $this->twigenvi->render('/templates/user/login.html.twig');
    }else{
      $con = $this->modelpost->checklogin($post);
      $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
      if(!empty($donnes)){
        echo 'user connect';
      }else{
        echo 'user no exist';
      }
    }
  }
}