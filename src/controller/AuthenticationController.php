<?php
/** 
 * The file is for authentification
 * 
 * PHP version 7.2.18
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\Controller;

use App\Controller\Controller;
use App\Entity\User;
use App\Tools\Session;
/**
 * Class for authentification
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class AuthentificationController extends Controller
{
    /**
     * Init controller
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Register a user
     * 
     * @return void
     */
    public function register()
    {
        if (empty(Session::getSession('id'))) {
            if (!empty($this->post)) {
                $donnes = $this->_modelAuth->check(new User($this->post));
                if (empty($donnes)) {
                    $this->_modelAuth->register(new User($this->post));
                    Session::setSession('alert', 'success');
                } else {
                    Session::setSession('alert', 'already');
                }
            }
            return $this->twig->render('/templates/authentication/register.html.twig');
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Login a user
     * 
     * @return void
     */
    public function login()
    {
        if (empty(Session::getSession('id'))) {
            if (!empty($this->post)) {
                $donnes = $this->_modelAuth->check(new User($this->post));
                if (empty($donnes)) {
                    Session::setSession('alert', 'email');
                } elseif (password_verify($this->post['password'], $donnes->password)) {
                    Session::setSession('id', $donnes->id);
                    Session::setSession('role', $donnes->roleId);
                    header("Location:/");
                    exit;
                } else {
                    Session::setSession('alert', 'password');
                }
            }
            return $this->twig->render('/templates/authentication/login.html.twig');
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Logout a user
     * 
     * @return void
     */
    public function logout()
    {
        Session::deleteAllSession();
        header("Location:/");
        exit;
    }
}
