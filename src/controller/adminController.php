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
use App\Entity\Commentaire;
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
     * Init model and session
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Role a user
     * 
     * @return template
     */
    public function roles()
    {
        if ($this->_usersession['role'] == 3) {
            if (!empty($this->post)) {
                $this->_modelAdmin->updaterole(new User($this->post, 'post'));
            }
            $donnes = $this->_modelAdmin->roles(new User(['id'=>$this->_usersession['id']]));
            return $this->render('/templates/user/user.html.twig', ['user'=>$donnes]);
        }
        return header("LOCATION:/");
    }
    /**
     * Page admin
     * 
     * @return template
     */
    public function admin()
    {
        if ($this->_usersession['role'] == 3) {
            return $this->render('/templates/user/admin.html.twig');
        }
        return header("LOCATION:/");
    }
    /**
     * Show comment valid and comment invalid
     * 
     * @param string $type The param is to know if the comment is to be created or modified
     * 
     * @return template
     */
    public function comment($type)
    {
        if ($this->_usersession['role'] == 3) {
            if (!empty($this->post)) {
                $this->_modelAdmin->updatecomment(new Commentaire($this->post, 'post'));
                }
                $donnes = $this->_modelAdmin->$type();
                return $this->render('/templates/user/comment.html.twig', ['return'=>$type,'comment'=>$donnes]);
        }
        return header("LOCATION:/");
    }
    /**
     * Delete comment
     * 
     * @param integer $id  it's id comment
     * @param array   $url the paramis here to find out in which url was doing the deletion
     * 
     * @return template
     */
    public function deletecomment($id,$url)
    {
        if ($this->_usersession['role'] == 3 && !empty($id)) {
            $this->_modelAdmin->deletecomment(new Commentaire(['id'=>$id]));
            return $this->comment($url);
        }
        return header("LOCATION:/");
    }
    /**
     * Delete user
     * 
     * @param integer $id it's user data
     * 
     * @return template
     */
    public function deleteuser($id)
    {
        if ($this->_usersession['role'] == 3 && !empty($id)) {
            $this->_modelAdmin->deleteuser(new User(['id'=>$id]));
            return $this->roles();
        }
        return header("LOCATION:/");
    }
    /**
     * Update user (name,email)
     * 
     * @return template
     */
    public function updateuser()
    {
        if (isset($this->_usersession['id'])) {
            if (!empty($this->post)) {
                $this->post['id']=$this->_usersession['id'];
                $this->_modelAdmin->updateuser(new User(($this->post), 'post'));
            }
            $donnes = $this->_modelAdmin->getuser(new User(['id'=>$this->_usersession['id']]));
            return $this->render('/templates/user/updateuser.html.twig', ['user'=>$donnes]);
        }
        return header("LOCATION:/");
    }
     /**
      * Update the password with the old password
      * 
      * @return template
      */
    public function updatepassword()
    {
        if (isset($this->_usersession['id'])) {
            if (!empty($this->post)) {
                $donnes = $this->_modelAdmin->getuser(new User(['id'=>$this->_usersession['id']]));
                if (password_verify($this->post['oldpassword'], $donnes->mdp)) {
                    $this->_modelAdmin->updatepassword(new User(['mdp'=>$this->post['newpassword'],'id'=>$this->_usersession['id']], 'post'));
                } else {
                    (new Flash())->setFlash(['danger'=>'danger']);
                }
            }
            return $this->render('/templates/user/updatepassword.html.twig');
        }
        return header("LOCATION:/");
    }
}