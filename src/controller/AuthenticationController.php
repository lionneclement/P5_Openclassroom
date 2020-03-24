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
use App\Flash\Flash;
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
        if (empty($this->getSession('id'))) {
            if (!empty($this->post)) {
                $donnes = $this->_modelAuth->check(new User($this->post));
                if (empty($donnes)) {
                    $this->_modelAuth->register(new User($this->post, 'post'));
                } else {
                    (new Flash())->setFlash(['already'=>'already']);
                }
            }
            return $this->render('/templates/authentication/register.html.twig');
        }
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Login a user
     * 
     * @return void
     */
    public function login()
    {
        if (empty($this->getSession('id'))) {
            if (!empty($this->post)) {
                $donnes = $this->_modelAuth->check(new User($this->post, 'post'));
                if (empty($donnes)) {
                    (new Flash())->setFlash(['emailerror'=>'email']);
                } elseif (password_verify($this->post['mdp'], $donnes->mdp)) {
                    $this->confsession($donnes);
                    header("Location:/");
                } else {
                    (new Flash())->setFlash(['mdperror'=>'mdp']);
                }
            }
            return $this->render('/templates/authentication/login.html.twig');
        }
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Logout a user
     * 
     * @return void
     */
    public function logout()
    {
        session_unset();
        header("Location:/");
    }
    /**
     * Create session
     * 
     * @param array $user it's user id and user role
     * 
     * @return void
     */
    public function confSession(object $user)
    {
        $this->setSession('id', $user->id);
        $this->setSession('role', $user->role_id);
    }
}
