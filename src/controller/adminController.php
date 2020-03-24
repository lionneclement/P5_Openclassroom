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
use App\Flash\Flash;

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
     * Role a user
     * 
     * @return void
     */
    public function roles()
    {
        if ($this->getSession('role') == 3) {
            if (!empty($this->post)) {
                $this->_modelAdmin->updateRole(new User($this->post, 'post'));
            }
            $donnes = $this->_modelAdmin->roles(new User(['id'=>$this->getSession('id')]));
            return $this->render('/templates/user/user.html.twig', ['user'=>$donnes]);
        }
        return $this->render("/templates/error.html.twig");
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
        if ($this->getSession('role') == 3 && !empty($id)) {
            $this->_modelAdmin->deleteUser(new User(['id'=>$id]));
            return $this->roles();
        }
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Update user (name,email)
     * 
     * @return void
     */
    public function updateUser()
    {
        if (!empty($this->getSession('id'))) {
            if (!empty($this->post)) {
                $this->post['id']=$this->getSession('id');
                $this->_modelAdmin->updateUser(new User(($this->post), 'post'));
            }
            $donnes = $this->_modelAdmin->getUser(new User(['id'=>$this->getSession('id')]));
            return $this->render('/templates/user/updateuser.html.twig', ['user'=>$donnes]);
        }
        return $this->render("/templates/error.html.twig");
    }
}
