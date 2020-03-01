<?php
namespace App\controller;

use App\twig\twigenvi;
use App\controller\mpost;

class cblogposts extends twigenvi
{
  public function page()
  {
    $posts = new mpost;
    $con = $posts->posts();
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/blogposts.html.twig',['nom'=>$donnes]);
  }
}