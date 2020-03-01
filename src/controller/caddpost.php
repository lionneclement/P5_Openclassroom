<?php
namespace App\controller;

use App\twig\twigenvi;
use App\controller\mpost;
use App\controller\cblogposts;

class addpost extends twigenvi
{
  public function contact()
  {
    echo $this->twigenvi->render('/templates/addpost.html.twig');
  }
  public function add($post)
  {
    $addpost = new mpost;
    $addpost->add($post);
    return header("LOCATION:/posts");
  }
}