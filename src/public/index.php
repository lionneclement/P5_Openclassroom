<?php

require '../../vendor/autoload.php';
require '../../src/twig/twigenvi.php';
require '../controller/publicController.php';
require '../controller/adminController.php';
require '../model/connectmodel.php';
require '../model/adminmodel.php';
require '../model/publicmodel.php';

use App\controller\admincontroller;
use App\controller\publiccontroller;

 $router = new AltoRouter();

 $router->map('GET', '/', function() {
	$page = new publiccontroller;
    $page->home();
});
 $router->map('GET', '/posts', function() {
    $page = new publiccontroller;
    $page->allposts();
});
$router->map('GET', '/post/[i:id]', function($id) {
    $page = new publiccontroller;
    $page->onepost($id);
});
$router->map('GET|POST', '/admin/addpost', function() {
    $page = new publiccontroller;
    $page->add($_POST);
});
$router->map('GET|POST', '/updatepost/[i:id]', function($id) {
    $page = new publiccontroller;
    $page->update($id,$_POST); 
});
$router->map('GET', '/removepost/[i:id]', function($id) {
    $page = new publiccontroller;
    $page->remove($id);
});
 $router->map('POST','/mail',function() {
    $page = new publiccontroller();
    $page->sendmail($_POST);
});
$router->map('GET|POST','/register',function() {
    $page = new admincontroller;
    $page->register($_POST);
});
$router->map('GET|POST','/login',function() {
    $page = new admincontroller;
    $page->login($_POST);
});
$router->map('GET','/logout',function(){
    $page = new admincontroller;
    $page->logout();
});
$router->map('GET|POST','/admin/roles',function(){
    $page = new admincontroller;
    $page->roles($_POST);
});
$router->map('GET','/admin',function(){
    $page = new admincontroller;
    $page->admin();
});
$router->map('POST','/comment',function(){
    $page = new publiccontroller;
    $page->comment($_POST);
});
$router->map('GET|POST','/admin/comment',function(){
    $page = new admincontroller;
    $page->comment($_POST);
});
$router->map('GET|POST','/admin/commentinvalide',function(){
    $page = new admincontroller;
    $page->commentinvalide($_POST);
});

  
$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}