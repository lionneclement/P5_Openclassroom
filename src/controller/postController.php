<?php
namespace App\controller;

use App\twig\twigenvi;
use App\model\postmodel;
use App\model\entity;

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
  public function home($post)
  {
    if(empty($post)){
      echo $this->twigenvi->render('/templates/home.html.twig',['access'=>$this->usercookie['role']]);
    }else{
      $recaptcha = new \ReCaptcha\ReCaptcha('6Lcchd8UAAAAANvIG5v94AgBnvVlY_nCf0jIdR14');
      $resp = $recaptcha->setExpectedHostname('localhost')
                        ->verify($post['g-recaptcha-response'],$_SERVER['REMOTE_ADDR']);
      if ($resp->isSuccess()) {
        $obj =  new entity($post);
        mail($obj->getemail(),$obj->getprenom().$obj->getnom(),$obj->getmessage());
        echo '<script language="javascript">alert("Votre message viens d\'être envoyer !");window.location.replace("/")</script>';
      }else {
        echo '<script language="javascript">alert("Vous devez remplir le reCAPTCHA!");window.location.replace("/")</script>';
        $error = $resp->getErrorCodes();
      }
    } 
  }
  public function update($id,$post)
  {
    if(isset($this->usercookie) && $this->usercookie['role'] >= 2){
      if(empty($post)){
        $con = $this->modelpost->post(new entity(array('article_id'=>$id)));
        $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/post/postform.html.twig',['url'=>'/updatepost/'.$id.'','donnes'=>$donnes,'access'=>$this->usercookie['role']]);
      }else {
        $post['id']=$id;
        $this->modelpost->update(new entity($post));
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
        $this->modelpost->add(new entity($post));
        return header("LOCATION:/posts");
      }
    }
    else{
      return header("LOCATION:/");
    }
  }
  public function onepost($id)
  {
    $con = $this->modelpost->post(new entity(array('article_id'=>$id)));
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    $con1 = $this->modelpost->allcomment(new entity(array('article_id'=>$id)));
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
      $this->modelpost->remove(new entity(array('article_id'=>$id)));
      return header("LOCATION:/posts");
    }else{
      return header("LOCATION:/");
    }
  }
  public function comment($post)
  {
    if(isset($this->usercookie)){
      $this->modelpost->addcomment(new entity(array('message'=>$post['contenu'],'user_id'=>$this->usercookie['id'],'article_id'=>$post['id'])));
      return header('LOCATION:/post/'.$post['id'].'');
    }else{
      return header("LOCATION:/");
    }
  }
}