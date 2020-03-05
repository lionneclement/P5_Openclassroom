<?php
namespace App\controller;

use App\twig\twigenvi;
use App\model\postmodel;

class postcontroller extends twigenvi
{
  private $modelpost;
  private $usercookie;

  public function __construct()
  {
    parent::__construct();
    $this->modelpost = new postmodel;
    if (isset($_COOKIE['id'])){
      $this->usercookie['id'] = $_COOKIE['id'];
      $this->usercookie['role'] = $_COOKIE['role'];
    }
  }
  public function home()
  {
    echo $this->twigenvi->render('/templates/home.html.twig',['access'=>$this->usercookie['role']]);
  }
  public function sendmail($post)
  {
    mail($post['email'],$post['prenom'].$post['nom'] ,$post['message']);
  }
  public function update($id,$post)
  {
    if(isset($this->usercookie) && $this->usercookie['role'] >= 2){
      if(empty($post)){
        $con = $this->modelpost->post($id);
        $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/post/postform.html.twig',['url'=>'/updatepost/'.$id.'','donnes'=>$donnes,'access'=>$this->usercookie['role']]);
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
        echo $this->twigenvi->render('/templates/post/postform.html.twig',['url'=>'addpost','access'=>$this->usercookie['role']]);
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
    $con1 = $this->modelpost->allcomment($id);
    $donnes1 = $con1->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/post/onepost.html.twig',['nom'=>$donnes,'comment'=>$donnes1,'access'=>$this->usercookie['role']]);
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
  public function comment($post)
  {
    if(isset($this->usercookie)){
      $con = $this->modelpost->post($post['id']);
      $donnes = $con->fetch(\PDO::FETCH_ASSOC);
      $array= [
        'message'=>$post['contenu'],
        'user_id'=>$this->usercookie['id'],
        'article_id'=>$donnes['id']
      ];
      $this->modelpost->addcomment($array);
      return header('LOCATION:/post/'.$post['id'].'');
    }else{
      return header("LOCATION:/");
    }
  }
}