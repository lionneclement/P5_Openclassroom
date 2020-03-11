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
require '../../src/twig/TwigEnvironment.php';
require '../controller/PostController.php';
require '../controller/AdminController.php';
require '../controller/AuthenticationController.php';
require '../model/ModelConnect.php';
require '../model/ModelAdmin.php';
require '../model/ModelPost.php';
require '../model/ModelAuthentification.php';
require '../manager/ManagerValide.php';
require '../manager/ManagerArticle.php';
require '../manager/ManagerCommentaire.php';
require '../manager/ManagerUser.php';
require '../manager/ManagerContact.php';

use App\controller\Admincontroller;
use App\controller\Postcontroller;
use App\controller\AuthentificationController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('../../');
$dotenv->load();
$router = new AltoRouter();

$router->map(
    'GET|POST', '/', function () {
        $page = new Postcontroller;
        $page->home($_POST);
    }
);
$router->map(
    'GET', '/posts', function () {
        $page = new Postcontroller;
        $page->allposts();
    }
);
$router->map(
    'GET', '/post/[i:id]', function ($id) {
        $page = new Postcontroller;
        $page->onepost($id);
    }
);
$router->map(
    'GET|POST', '/admin/addpost', function () {
        $page = new Postcontroller;
        $page->addUpdate($_POST);
    }
);
$router->map(
    'GET|POST', '/updatepost/[i:id]', function ($id) {
        $page = new Postcontroller;
        $page->addUpdate($_POST, $id); 
    }
);
$router->map(
    'GET', '/removepost/[i:id]', function ($id) {
        $page = new Postcontroller;
        $page->remove($id);
    }
);
$router->map(
    'GET|POST', '/register', function () {
        $page = new AuthentificationController;
        $page->register($_POST);
    }
);
$router->map(
    'GET|POST', '/login', function () {
        $page = new AuthentificationController;
        $page->login($_POST);
    }
);
$router->map(
    'GET', '/logout', function () {
        $page = new AuthentificationController;
        $page->logout();
    }
);
$router->map(
    'GET|POST', '/admin/roles', function () {
        $page = new Admincontroller;
        $page->roles($_POST);
    }
);
$router->map(
    'GET', '/admin', function () {
        $page = new Admincontroller;
        $page->admin();
    }
);
$router->map(
    'POST', '/comment', function () {
        $page = new Postcontroller;
        $page->comment($_POST);
    }
);
$router->map(
    'GET|POST', '/admin/[a:action]', function ($action) {
        $page = new Admincontroller;
        $page->comment($_POST, $action);
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
    'GET|POST', '/resetpassword', function () {
        $page = new AuthentificationController;
        $page->resetpassword($_POST);
    }
);
$router->map(
    'GET|POST', '/resetlink/[i:id]/[a:action]', function ($id,$action) {
        $page = new AuthentificationController;
        $page->resetlink($id, $action, $_POST);
    }
);
$router->map(
    'GET|POST', '/updateuser', function () {
        $page = new Admincontroller;
        $page->updateuser($_POST);
    }
);
$router->map(
    'GET|POST', '/updatepassword', function () {
        $page = new Admincontroller;
        $page->updatepassword($_POST);
    }
);

  
 $match = $router->match();

if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']); 
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}