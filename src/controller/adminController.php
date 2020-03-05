<?php
namespace App\controller;

use App\twig\twigenvi;
use App\model\adminmodel;

class admincontroller extends twigenvi
{
  private $modelpost;
  private $usercookie;
  public function __construct()
  {
    parent::__construct();
    $this->modelpost = new adminmodel;
    if (isset($_COOKIE['id'])){
      $this->usercookie['id'] = $_COOKIE['id'];
      $this->usercookie['role'] = $_COOKIE['role'];
    }
  }
  public function register($post)
  {
    if(!isset($this->usercookie)){
      if(empty($post)){
        echo $this->twigenvi->render('/templates/user/register.html.twig');
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
    if(!isset($this->usercookie)){
      if(empty($post)){
        echo $this->twigenvi->render('/templates/user/login.html.twig');
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
  public function roles($post)
  {
    if($this->usercookie['role'] == 3){
      if(empty($post)){
        $con = $this->modelpost->roles($this->usercookie['id']);
        $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/user/user.html.twig',['user'=>$donnes,'access'=>$this->usercookie['role']]);
      }else{
        $this->modelpost->updaterole($post);
        return header("LOCATION:/admin/roles");
      }
    }else{
      return header("LOCATION:/");
    }
  }
  public function admin()
  {
    if($this->usercookie['role'] == 3){
        echo $this->twigenvi->render('/templates/user/admin.html.twig',['access'=>$this->usercookie['role']]);
    }else{
      return header("LOCATION:/");
    }
  }
  public function comment($post,$type)
  {
    if($this->usercookie['role'] == 3){
      if(empty($post)){
        $con = $this->modelpost->$type();
        $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/user/comment.html.twig',['return'=>$type,'comment'=>$donnes,'access'=>$this->usercookie['role']]);
      }else{
        $this->modelpost->updatecomment($_POST);
        return header("LOCATION:/admin/$type");
      }
    }else{
      return header("LOCATION:/");
    }
  }
  public function deletecomment($id,$url)
  {
    if($this->usercookie['role'] == 3 && !empty($id)){
      $this->modelpost->deletecomment($id);
      return header("LOCATION:/admin/$url");
    }else{
      return header("LOCATION:/");
    }
  }
}