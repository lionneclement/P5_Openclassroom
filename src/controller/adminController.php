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

use App\Twig\Twigenvi;
use App\Model\Adminmodel;
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
class Admincontroller extends Twigenvi
{
    private $_modelpost;
    private $_usersession;
    /**
     * Init model and session
     */
    public function __construct()
    {
        parent::__construct();
        $this->_modelpost = new Adminmodel;
        $this->_usersession['id'] = &$_SESSION['id'];
        $this->_usersession['role'] = &$_SESSION['role'];
    }
    /**
     * Role a user
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function roles($post)
    {
        if ($this->_usersession['role'] == 3) {
            if (empty($post)) {
                $con = $this->_modelpost->roles(new User(['id'=>$this->_usersession['id']]));
                $donnes = $con->fetchAll(\PDO::FETCH_OBJ);
                return $this->render('/templates/user/user.html.twig', ['user'=>$donnes]);
            } else {
                $this->_modelpost->updaterole(new User($post));
                $flash = new Flash();
                $flash->setFlash([]);
                return header("LOCATION:/admin/roles");
            }
        } else {
            return header("LOCATION:/");
        }
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
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Show comment valid and comment invalid
     * 
     * @param array  $post it's user data
     * @param string $type The param is to know if the comment is to be created or modified
     * 
     * @return template
     */
    public function comment($post,$type)
    {
        if ($this->_usersession['role'] == 3) {
            if (empty($post)) {
                $con = $this->_modelpost->$type();
                $donnes = $con->fetchAll(\PDO::FETCH_OBJ);
                return $this->render('/templates/user/comment.html.twig', ['return'=>$type,'comment'=>$donnes]);
            } else {
                $this->_modelpost->updatecomment(new Commentaire($post));
                $flash = new Flash();
                $flash->setFlash([]);
                return header("LOCATION:/admin/comment/$type");
            }
        } else {
            return header("LOCATION:/");
        }
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
            $this->_modelpost->deletecomment(new Commentaire(['id'=>$id]));
            return header("LOCATION:/admin/comment/$url");
        } else {
            return header("LOCATION:/");
        }
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
            $this->_modelpost->deleteuser(new User(['id'=>$id]));
            return header("LOCATION:/admin/roles");
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Update user (name,email)
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function updateuser($post)
    {
        if (isset($this->_usersession['id'])) {
            $con = $this->_modelpost->getuser(new User(['id'=>$this->_usersession['id']]));
            $donnes = $con->fetch(\PDO::FETCH_OBJ);
            if (empty($post)) {
                return $this->render('/templates/user/updateuser.html.twig', ['user'=>$donnes]);
            } else {
                $entitypost=new User($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $post['id']=$this->_usersession['id'];
                    $this->_modelpost->updateuser(new User(($post)));
                    $flash = new Flash();
                    $flash->setFlash([]);
                    return header("LOCATION:/admin/updateuser");
                } else {
                    return header("LOCATION:/admin/updateuser");
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
     /**
      * Update the password with the old password
      * 
      * @param array $post it's user data
      * 
      * @return template
      */
    public function updatepassword($post)
    {
        if (isset($this->_usersession['id'])) {
            if (empty($post)) {
                return $this->render('/templates/user/updatepassword.html.twig');
            } else {
                $con = $this->_modelpost->getuser(new User(['id'=>$this->_usersession['id']]));
                $donnes = $con->fetch(\PDO::FETCH_OBJ);
                $flash = new Flash();
                if (password_verify($post['oldpassword'], $donnes->mdp)) {
                    $entitypost=new User(['mdp'=>$post['newpassword']]);
                    $checking = $entitypost->isValid(['mdp'=>$post['newpassword']]);
                    if (empty($checking)) {
                        $this->_modelpost->updatepassword($entitypost);
                        $flash->setFlash([]);
                        return header("LOCATION:/admin/updatepassword");
                    } else {
                        return header("LOCATION:/admin/updatepassword");
                    }
                } else {
                    $flash->setFlash(['danger'=>'danger']);
                    return header("LOCATION:/admin/updatepassword");
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
}