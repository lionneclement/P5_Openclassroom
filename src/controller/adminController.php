<?php
namespace App\controller;

use App\twig\twigenvi;
use App\model\adminmodel;
use App\model\postmodel;
use App\model\entity;

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
        $con = $this->modelpost->check(new entity(array('email'=>$post['email'])));
        $donnes = $con->fetchAll();
        if(empty($donnes)){
          $this->modelpost->register(new entity($post));
          echo '<script language="javascript">alert("Votre compte vient d\'être créé, vous pouvez vous connecter !");window.location.replace("/login")</script>';
        }else{
          echo '<script language="javascript">alert("Votre compte existe déjà connecter vous !");window.location.replace("/login")</script>';
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
        $con = $this->modelpost->check(new entity(array('email'=>$post['email'])));
        $donnes = $con->fetch(\PDO::FETCH_ASSOC);
        if(!empty($donnes) && password_verify($post['mdp'],$donnes['mdp'])){
          $this->confcookie($donnes);
          echo '<script language="javascript">alert("Vous êtes connecter !");window.location.replace("/")</script>';
        }else{
          echo '<script language="javascript">alert("L\'email ou le mot de passe est incorrect !");window.location.replace("/login")</script>';
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
        $con = $this->modelpost->roles(new entity(array('user_id'=>$this->usercookie['id'])));
        $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/user/user.html.twig',['user'=>$donnes,'access'=>$this->usercookie['role']]);
      }else{
        $this->modelpost->updaterole(new entity($post));
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
        $this->modelpost->updatecomment(new entity($post));
        return header("LOCATION:/admin/$type");
      }
    }else{
      return header("LOCATION:/");
    }
  }
  public function deletecomment($id,$url)
  {
    if($this->usercookie['role'] == 3 && !empty($id)){
      $this->modelpost->deletecomment(new entity(array('id'=>$id)));
      return header("LOCATION:/admin/$url");
    }else{
      return header("LOCATION:/");
    }
  }
  public function deleteuser($id)
  {
    if($this->usercookie['role'] == 3 && !empty($id)){
      $con = $this->modelpost->getpost(new entity(array('user_id'=>$id)));
      $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
      foreach($donnes as $val){
        $postmodel = new postmodel;
        $postmodel->remove(new entity(array('article_id'=>$val['id'])));
      }
      $this->modelpost->deleteuser(new entity(array('id'=>$id)));
      return header("LOCATION:/admin/roles");
    }else{
      return header("LOCATION:/");
    }
  }
  public function resetpassword($post)
  {
    if(empty($post)){
      echo $this->twigenvi->render('/templates/user/reset.html.twig');
    }else{
      $con = $this->modelpost->check(new entity(array('email'=>$post['email'])));
      $donnes = $con->fetch();
      if(empty($donnes)){
        echo '<script language="javascript">alert("L\'email est incorrect !");window.location.replace("/login")</script>';
      }else{
        setcookie('reset',$post['email'],time()+(60*60*24*30),'/');
        mail($post['email'],'Changement de mot de passe','Voici le lien pour changer de mot de passe: http://localhost/resetlink');
        echo '<script language="javascript">alert("Vous allez recevoir un email.");window.location.replace("/resetpassword")</script>';
      }
    }
  }
  public function resetlink()
  {
    if(isset($_COOKIE['reset'])){
      $regex="/@[a-zA-Z.]*/";
      $new = preg_replace($regex,'',$_COOKIE['reset']);
      $password = new entity(array('mdp'=>$new));
      $this->modelpost->resetpassword($password,$_COOKIE['reset']);
      mail($_COOKIE['reset'],'Changement de mot de passe','Voici votre nouveau mot de passe: \''.$new.'\'. N\'oublier pas de le changer');
      setcookie('reset','',-1,'/');
      echo '<script language="javascript">alert("Vous allez recevoir un nouvelle email avec votre nouveau mot de passe.");window.location.replace("/login")</script>';
    }else{
      return header("LOCATION:/");
    }
  }
  public function updateuser($post)
  {
    if(isset($this->usercookie['id'])){
      if(empty($post)){
        $con = $this->modelpost->getuser(new entity(array('id'=>$this->usercookie['id'])));
        $donnes = $con->fetch(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/user/updateuser.html.twig',['user'=>$donnes,'access'=>$this->usercookie['role']]);
      }else{
        $this->modelpost->updateuser(new entity(array('nom'=>$post['nom'],'prenom'=>$post['prenom'],'email'=>$post['email'],'id'=>$this->usercookie['id'])));
        return header("LOCATION:/updateuser");
      }
    }else{
      return header("LOCATION:/");
    }
  }
}