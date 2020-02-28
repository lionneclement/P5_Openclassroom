<?php
namespace App\controller;

use App\twig\twigenvi;

class home extends twigenvi
{
  public function accueil()
  {
    echo $this->twigenvi->render('/templates/home.html.twig');
  }
}