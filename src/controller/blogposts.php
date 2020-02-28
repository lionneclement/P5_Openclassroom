<?php
namespace App\controller;

require '../../src/twig/twigenvi.php';

use App\twig\twigenvi;

class blogposts extends twigenvi
{
  public function page()
  {
    echo $this->twigenvi->render('blogposts.html.twig');
  }
}