<?php

require '../../vendor/autoload.php';
require '../../src/twig/twigenvi.php';
require '../controller/postController.php';
require '../controller/adminController.php';
require '../model/connectmodel.php';
require '../model/adminmodel.php';
require '../model/postmodel.php';
require '../model/entity.php';

use App\controller\admincontroller;
use App\controller\postcontroller;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('../../');
$dotenv->load();
$router = new AltoRouter();

 $router->map('GET|POST', '/', function() {
	$page = new postcontroller;
    $page->home($_POST);
});
 $router->map('GET', '/posts', function() {
    $page = new postcontroller;
    $page->allposts();
});
$router->map('GET', '/post/[i:id]', function($id) {
    $page = new postcontroller;
    $page->onepost($id);
});
$router->map('GET|POST', '/admin/addpost', function() {
    $page = new postcontroller;
    $page->add($_POST);
});
$router->map('GET|POST', '/updatepost/[i:id]', function($id) {
    $page = new postcontroller;
    $page->update($id,$_POST); 
});
$router->map('GET', '/removepost/[i:id]', function($id) {
    $page = new postcontroller;
    $page->remove($id);
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
    $page = new postcontroller;
    $page->comment($_POST);
});
$router->map('GET|POST','/admin/[a:action]',function($action){
    $page = new admincontroller;
    $page->comment($_POST,$action);
});
$router->map('GET','/admin/deletecomment/[i:id]/[a:action]',function($id,$action){
    $page = new admincontroller;
    $page->deletecomment($id,$action);
});
$router->map('GET','/admin/deleteuser/[i:id]',function($id){
    $page = new admincontroller;
    $page->deleteuser($id);
});
$router->map('GET|POST','/resetpassword',function(){
    $page = new admincontroller;
    $page->resetpassword($_POST);
});
$router->map('GET|POST','/resetlink/[i:id]/[a:action]',function($id,$action){
    $page = new admincontroller;
    $page->resetlink($id,$action,$_POST);
});
$router->map('GET|POST','/updateuser',function(){
    $page = new admincontroller;
    $page->updateuser($_POST);
});
$router->map('GET|POST','/updatepassword',function(){
    $page = new admincontroller;
    $page->updatepassword($_POST);
});

  
$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}