<?php
namespace App\controller;

use App\twig\twigenvi;
use App\controller\mpost;

class updatepost extends twigenvi
{
  public function contact($id)
  {
    $post = new mpost;
    $con = $post->post($id);
    $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
    echo $this->twigenvi->render('/templates/updatepost.html.twig',['id'=>$id,'donnes'=>$donnes]);
  }
  public function update($id,$post)
  {
    $update = new mpost;
    $update->update($id,$post);
    return header("LOCATION:/posts");
  }
}