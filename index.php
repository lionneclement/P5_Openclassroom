<?php

require './vendor/autoload.php';
require './src/controller/blogposts.php';

use App\controller\blogposts;

 $request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/P5_Openclassroom/' :
        $blogposts = new blogposts;
        $blogposts->page();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}