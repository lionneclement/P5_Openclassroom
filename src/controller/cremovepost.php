<?php
namespace App\controller;

use App\twig\twigenvi;
use App\controller\mpost;

class removepost extends twigenvi
{
  public function remove($id)
  {
    $removepost = new mpost;
    $removepost->remove($id);
    return header("LOCATION:/posts");
  }
}