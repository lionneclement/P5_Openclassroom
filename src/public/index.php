<?php

require '../../vendor/autoload.php';
require '../../src/twig/twigenvi.php';
require '../controller/chome.php';
require '../controller/postController.php';
require '../controller/userController.php';
require '../model/mconnect.php';
require '../model/muser.php';
require '../model/mpost.php';

require '../mail/form.php';

use App\controller\user;
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
$router->map('GET|POST','/register',function() {
    $page = new user;
    $page->register($_POST);
});
$router->map('GET|POST','/login',function() {
    $page = new user;
    $page->login($_POST);
});

  
$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}