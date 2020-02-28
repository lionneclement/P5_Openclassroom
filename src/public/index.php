<?php

require '../../vendor/autoload.php';
require '../controller/blogposts.php';

use App\controller\blogposts;

 $request = $_SERVER['REQUEST_URI'];

 $router = new AltoRouter();

 // map homepage
 $router->map('GET', '/', function() {
    $home = new blogposts;
    $home->page();
});
  
$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}