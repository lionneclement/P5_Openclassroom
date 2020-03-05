<?php
namespace App\twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class twigenvi
{
  public function __construct()
  {
    $loader = new FilesystemLoader('../../src/view');
    $this->twigenvi = new Environment($loader);
  }
}