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

session_start();

use App\Controller\Admincontroller;
use App\Controller\Postcontroller;
use App\Controller\AuthentificationController;
use App\Controller\CommentController;
use App\Controller\PasswordController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('../../');
$dotenv->load();
$router = new AltoRouter();

$router->map(
    'GET|POST', '/', function () {
        (new Postcontroller)->home();
    }
);
$router->map(
    'GET', '/post/findAll', function () {
        (new Postcontroller)->allPosts();
    }
);
$router->map(
    'GET', '/post/findOne/[i:id]', function ($id) {
        (new Postcontroller)->onePost($id);
    }
);
$router->map(
    'GET|POST', '/post/addpost', function () {
        (new Postcontroller)->addUpdate();
    }
);
$router->map(
    'GET|POST', '/post/updatepost/[i:id]', function ($id) {
        (new Postcontroller)->addUpdate($id); 
    }
);
$router->map(
    'GET', '/post/removepost/[i:id]', function ($id) {
        (new Postcontroller)->remove($id);
    }
);
$router->map(
    'GET|POST', '/auth/register', function () {
        (new AuthentificationController)->register();
    }
);
$router->map(
    'GET|POST', '/auth/login', function () {
        (new AuthentificationController)->login();
    }
);
$router->map(
    'GET', '/auth/logout', function () {
        (new AuthentificationController)->logout();
    }
);
$router->map(
    'GET|POST', '/admin/roles', function () {
        (new Admincontroller)->roles();
    }
);
$router->map(
    'GET', '/admin/deleteuser/[i:id]', function ($id) {
        (new Admincontroller)->deleteUser($id);
    }
);
$router->map(
    'GET|POST', '/admin/updateuser', function () {
        (new Admincontroller)->updateUser();
    }
);
//Route for comment
$router->map(
    'GET|POST', '/admin/allinvalidecomment', function () {
        (new CommentController)->findAllInvalideComment();
    }
);
$router->map(
    'GET|POST', '/admin/allcomment', function () {
        (new CommentController)->findAllComment();
    }
);
$router->map(
    'GET|POST', '/admin/updatecomment/[i:id]/[a:action]', function ($id,$action) {
        (new CommentController)->updateComment($id, $action);
    }
);
$router->map(
    'GET', '/admin/deletecomment/[i:id]/[a:action]', function ($id,$action) {
        (new CommentController)->removeComment($id, $action);
    }
);
$router->map(
    'POST', '/post/addcomment', function () {
        (new CommentController)->addComment();
    }
);
//Route for password
$router->map(
    'GET|POST', '/password/sendlink', function () {
        (new PasswordController)->sendLinkForResetPassword();
    }
);
$router->map(
    'GET|POST', '/password/reset/[i:id]/[a:action]', function ($id,$action) {
        (new PasswordController)->resetPassword($id, $action);
    }
);
$router->map(
    'GET|POST', '/admin/updatepassword', function () {
        (new PasswordController)->updatePassword();
    }
);

 $match = $router->match();

if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']); 
} else {
    return (new Postcontroller)->error404();
}