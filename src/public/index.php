<?php

require '../../vendor/autoload.php';
require '../../src/twig/twigenvi.php';
require '../controller/cblogposts.php';
require '../controller/conepost.php';
require '../model/mpost.php';
require '../controller/chome.php';
require '../mail/form.php';

use App\controller\cblogposts;
use App\controller\conepost;
use App\controller\home;
use App\mail\email;

 $router = new AltoRouter();

 $router->map('GET', '/', function() {
	$page = new home;
    $page->accueil();
});
 $router->map('GET', '/posts', function() {
    $page = new cblogposts;
    $page->page();
});
$router->map('GET', '/post/[i:id]', function($id) {
    $page = new conepost;
    $page->post($id);
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