<?php
namespace App\controller;

use App\twig\twigenvi;
use App\controller\mpost;

class conepost extends twigenvi
{
  public function post($id)
  {
    $posts = new mpost;
    $con = $posts->post($id);
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/onepost.html.twig',['nom'=>$donnes]);
  }
}