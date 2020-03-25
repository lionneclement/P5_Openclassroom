<?php
/** 
 * The file is for managing connected users
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
 * Class for managing connected users
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Admincontroller extends Controller
{
    /**
     * Init manager and session
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Find all user
     * 
     * @return void
     */
    public function findAllUser()
    {
        if (Session::getSession('role') == 3) {
            if (!empty($this->post)) {
                $this->_modelAdmin->updateRole(new User($this->post));
                Session::setSession('alert', 'update');
            }
            $donnes = $this->_modelAdmin->roles(new User(['id'=>Session::getSession('id')]));
            return $this->twig->render('/templates/user/user.html.twig', ['user'=>$donnes]);
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Delete user
     * 
     * @param integer $id it's user data
     * 
     * @return void
     */
    public function deleteUser(int $id)
    {
        if (Session::getSession('role') == 3 && !empty($id)) {
            $this->_modelAdmin->deleteUser(new User(['id'=>$id]));
            Session::setSession('alert', 'delete');
            header("Location:/admin/roles");
            exit;
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Update user (name,email)
     * 
     * @return void
     */
    public function updateUser()
    {
        if (!empty(Session::getSession('id'))) {
            if (!empty($this->post)) {
                $this->post['id']=Session::getSession('id');
                $this->_modelAdmin->updateUser(new User(($this->post)));
                Session::setSession('alert', 'update');
            }
            $donnes = $this->_modelAdmin->getUser(new User(['id'=>Session::getSession('id')]));
            return $this->twig->render('/templates/user/updateuser.html.twig', ['user'=>$donnes]);
        }
        return $this->twig->render("/templates/error.html.twig");
    }
}
