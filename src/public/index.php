<?php

require '../../vendor/autoload.php';
require '../../src/twig/twigenvi.php';
require '../model/mpost.php';
require '../controller/chome.php';
require '../mail/form.php';
require '../controller/postController.php';

use App\controller\post;
use App\controller\home;
use App\mail\email;

 $router = new AltoRouter();

 $router->map('GET', '/', function() {
	$page = new home;
    $page->accueil();
});
 $router->map('GET', '/posts', function() {
    $page = new post;
    $page->allposts();
});
$router->map('GET', '/post/[i:id]', function($id) {
    $page = new post;
    $page->onepost($id);
});
$router->map('GET|POST', '/addpost', function() {
    $page = new post;
    $page->add($_POST);
});
$router->map('GET|POST', '/updatepost/[i:id]', function($id) {
    $page = new post;
    $page->update($id,$_POST); 
});
$router->map('GET', '/removepost/[i:id]', function($id) {
    $page = new post;
    $page->remove($id);
});
 $router->map('POST','/mail',function() {
    $page = new email($_POST);
    $page->send();
});

  
$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}