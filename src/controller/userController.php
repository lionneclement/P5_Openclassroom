<?php
namespace App\controller;

use App\twig\twigenvi;
use App\model\muser;

class user extends twigenvi
{
  private $modelpost;
  private $usercookie;
  public function __construct()
  {
    parent::__construct();
    $this->modelpost = new muser;
    $this->usercookie = isset($_COOKIE['id']);
  }
  public function register($post)
  {
    if(!$this->usercookie){
      if(empty($post)){
        echo $this->twigenvi->render('/templates/user/register.html.twig',['access'=>$this->usercookie]);
      }else{
        $con = $this->modelpost->check($post['email']);
        $donnes = $con->fetchAll();
        if(empty($donnes)){
          $post['mdp'] = password_hash($post['mdp'], PASSWORD_DEFAULT);
          $this->modelpost->register($post);
          echo 'user create';
        }else{
          echo 'already exits';
        }
      }
    }else{
      return header("LOCATION:/");
    }
  }
  public function login($post)
  {
    if(!$this->usercookie){
      if(empty($post)){
        echo $this->twigenvi->render('/templates/user/login.html.twig',['access'=>$this->usercookie]);
      }else{
        $con = $this->modelpost->check($post['email']);
        $donnes = $con->fetch(\PDO::FETCH_ASSOC);
        if(!empty($donnes) && password_verify($post['mdp'],$donnes['mdp'])){
          $this->confcookie($donnes);
          echo 'user connect';
        }else{
          echo 'user no exist';
        }
      }
    }else{
      return header("LOCATION:/");
    }
  }
  public function logout()
  {
    setcookie('id',$_COOKIE['id'],time() - 3600,'/');
    setcookie('role',$_COOKIE['role'],time() - 3600,'/');
    return header("LOCATION:/");
  }
  public function confcookie($user)
  {
    setcookie('id',$user['id'],time()+(60*60*24*30),'/');
    setcookie('role',$user['role_id'],time()+(60*60*24*30),'/');
  }
}