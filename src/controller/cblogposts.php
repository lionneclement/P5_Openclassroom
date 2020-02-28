<?php
namespace App\controller;

use App\twig\twigenvi;
use App\controller\mblogposts;

class cblogposts extends twigenvi
{
  public function page()
  {
    $connect = new mblogposts;
    $con = $connect->connect();
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/blogposts.html.twig',['nom'=>$donnes]);
  }
}