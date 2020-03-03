<?php
namespace App\controller;

use App\twig\twigenvi;
use App\controller\mpost;

class post extends twigenvi
{
  private $modelpost;
  private $usercookie;

  public function __construct()
  {
    parent::__construct();
    $this->modelpost = new mpost;
    if (isset($_COOKIE['id'])){
      $this->usercookie['id'] = $_COOKIE['id'];
      $this->usercookie['role'] = $_COOKIE['role'];
    }
  }
  public function update($id,$post)
  {
    if(isset($this->usercookie) && $this->usercookie['role'] >= 2){
      if(empty($post)){
        $con = $this->modelpost->post($id);
        $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/post/updatepost.html.twig',['id'=>$id,'donnes'=>$donnes,'access'=>$this->usercookie['role']]);
      }else {
        $this->modelpost->update($id,$post);
        return header("LOCATION:/posts");
      }
    }else{
      return header("LOCATION:/");
    }
  }
  public function add($post)
  {
    if(isset($this->usercookie) && $this->usercookie['role'] == 3){
      if(empty($post)){
        echo $this->twigenvi->render('/templates/post/addpost.html.twig',['access'=>$this->usercookie['role']]);
      }else{
        $this->modelpost->add($post);
        return header("LOCATION:/posts");
      } 
    }
    else{
      return header("LOCATION:/");
    }
  }
  public function onepost($id)
  {
    $con = $this->modelpost->post($id);
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/post/onepost.html.twig',['nom'=>$donnes,'access'=>$this->usercookie['role']]);
  }
  public function allposts()
  {
    $con = $this->modelpost->posts();
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/post/blogposts.html.twig',['nom'=>$donnes,'access'=>$this->usercookie['role']]);
  }
  
  public function remove($id)
  {
    if(isset($this->usercookie) && $this->usercookie['role'] == 3){
      $this->modelpost->remove($id);
      return header("LOCATION:/posts");
    }else{
      return header("LOCATION:/");
    }
  }
}