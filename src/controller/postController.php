<?php
namespace App\controller;

use App\twig\twigenvi;
use App\controller\mpost;

class post extends twigenvi
{
  private $modelpost;

  public function __construct()
  {
    parent::__construct();
    $this->modelpost = new mpost;
  }
  public function updateform($id)
  {
    $con = $this->modelpost->post($id);
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/post/updatepost.html.twig',['id'=>$id,'donnes'=>$donnes]);
  }
  public function onepost($id)
  {
    $con = $this->modelpost->post($id);
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/post/onepost.html.twig',['nom'=>$donnes]);
  }
  public function allposts()
  {
    $con = $this->modelpost->posts();
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/post/blogposts.html.twig',['nom'=>$donnes]);
  }
  public function updatepost($id,$post)
  {
    $this->modelpost->update($id,$post);
    return header("LOCATION:/posts");
  }
  public function remove($id)
  {
    $this->modelpost->remove($id);
    return header("LOCATION:/posts");
  }
  public function addform()
  {
    echo $this->twigenvi->render('/templates/post/addpost.html.twig');
  }
  public function addpost($post)
  {
    $this->modelpost->add($post);
    return header("LOCATION:/posts");
  }
}