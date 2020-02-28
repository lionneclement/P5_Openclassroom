<?php

require '../../vendor/autoload.php';
require '../../src/controller/cblogposts.php';

use App\controller\cblogposts;

 $request = $_SERVER['REQUEST_URI'];
var_dump($request);
 $router = new AltoRouter();

 $router->map('GET', '/', function() {
	echo 'hey';
});
 $router->map('GET', '/posts', function() {
    $home = new cblogposts;
    $home->page();
});
  
$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}