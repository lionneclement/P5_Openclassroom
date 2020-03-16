<?php
/** 
 * The file is the index of this repository
 * 
 * PHP version 7.2.18
 * 
 * @category Public
 * @package  Public
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
require '../../vendor/autoload.php';

use App\Controller\Admincontroller;
use App\Controller\Postcontroller;
use App\Controller\AuthentificationController;
use Dotenv\Dotenv;

session_start();

$dotenv = Dotenv::createImmutable('../../');
$dotenv->load();
$router = new AltoRouter();

$router->map(
    'GET|POST', '/', function () {
        $page = new Postcontroller;
        $page->home();
    }
);
$router->map(
    'GET', '/post/findAll', function () {
        $page = new Postcontroller;
        $page->allposts();
    }
);
$router->map(
    'GET', '/post/findOne/[i:id]', function ($id) {
        $page = new Postcontroller;
        $page->onepost($id);
    }
);
$router->map(
    'GET|POST', '/post/addpost', function () {
        $page = new Postcontroller;
        $page->addUpdate();
    }
);
$router->map(
    'GET|POST', '/post/updatepost/[i:id]', function ($id) {
        $page = new Postcontroller;
        $page->addUpdate($id); 
    }
);
$router->map(
    'POST', '/post/comment', function () {
        $page = new Postcontroller;
        $page->commentPost();
    }
);
$router->map(
    'GET', '/post/removepost/[i:id]', function ($id) {
        $page = new Postcontroller;
        $page->remove($id);
    }
);
$router->map(
    'GET|POST', '/auth/register', function () {
        $page = new AuthentificationController;
        $page->register();
    }
);
$router->map(
    'GET|POST', '/auth/login', function () {
        $page = new AuthentificationController;
        $page->login();
    }
);
$router->map(
    'GET', '/auth/logout', function () {
        $page = new AuthentificationController;
        $page->logout();
    }
);
$router->map(
    'GET|POST', '/auth/resetpassword', function () {
        $page = new AuthentificationController;
        $page->resetpassword();
    }
);
$router->map(
    'GET|POST', '/auth/resetlink/[i:id]/[a:action]', function ($id,$action) {
        $page = new AuthentificationController;
        $page->resetlink($id, $action);
    }
);
$router->map(
    'GET|POST', '/admin/roles', function () {
        $page = new Admincontroller;
        $page->roles();
    }
);
$router->map(
    'GET', '/admin', function () {
        $page = new Admincontroller;
        $page->admin();
    }
);
$router->map(
    'GET|POST', '/admin/comment/[a:action]', function ($action) {
        $page = new Admincontroller;
        $page->comment($action);
    }
);
$router->map(
    'GET', '/admin/deletecomment/[i:id]/[a:action]', function ($id,$action) {
        $page = new Admincontroller;
        $page->deletecomment($id, $action);
    }
);
$router->map(
    'GET', '/admin/deleteuser/[i:id]', function ($id) {
        $page = new Admincontroller;
        $page->deleteuser($id);
    }
);
$router->map(
    'GET|POST', '/admin/updateuser', function () {
        $page = new Admincontroller;
        $page->updateuser();
    }
);
$router->map(
    'GET|POST', '/admin/updatepassword', function () {
        $page = new Admincontroller;
        $page->updatepassword();
    }
);

  
 $match = $router->match();

if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']); 
} else {
    $server = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_SPECIAL_CHARS);
    header($server . ' 404 Not Found');
}