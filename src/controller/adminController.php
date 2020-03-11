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
namespace App\controller;

use App\twig\twigenvi;
use App\model\adminmodel;
use App\entity\user;
use App\entity\commentaire;
/**
 * Class for managing connected users
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Admincontroller extends twigenvi
{
    private $_modelpost;
    private $_usercookie;
    /**
     * Init model and cookie
     */
    public function __construct()
    {
        parent::__construct();
        $this->_modelpost = new adminmodel;
        if (isset($_COOKIE['id'])) {
            $this->_usercookie['id'] = $_COOKIE['id'];
            $this->_usercookie['role'] = $_COOKIE['role'];
        }
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
        if ($this->_usercookie['role'] == 3) {
            if (empty($post)) {
                $con = $this->_modelpost->roles(new user(array('id'=>$this->_usercookie['id'])));
                $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
                echo $this->twigenvi->render('/templates/user/user.html.twig', ['user'=>$donnes,'access'=>$this->_usercookie['role']]);
            } else {
                $this->_modelpost->updaterole(new user($post));
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
        if ($this->_usercookie['role'] == 3) {
            echo $this->twigenvi->render('/templates/user/admin.html.twig', ['access'=>$this->_usercookie['role']]);
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Show all comments and update comment
     * 
     * @param array  $post it's user data
     * @param string $type The param is to know if the comment is to be created or modified
     * 
     * @return template
     */
    public function comment($post,$type)
    {
        if ($this->_usercookie['role'] == 3) {
            if (empty($post)) {
                $con = $this->_modelpost->$type();
                $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
                echo $this->twigenvi->render('/templates/user/comment.html.twig', ['return'=>$type,'comment'=>$donnes,'access'=>$this->_usercookie['role']]);
            } else {
                $this->_modelpost->updatecomment(new commentaire($post));
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
        if ($this->_usercookie['role'] == 3 && !empty($id)) {
            $this->_modelpost->deletecomment(new commentaire(array('id'=>$id)));
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
        if ($this->_usercookie['role'] == 3 && !empty($id)) {
            $this->_modelpost->deleteuser(new user(array('id'=>$id)));
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
        if (isset($this->_usercookie['id'])) {
            $con = $this->_modelpost->getuser(new user(array('id'=>$this->_usercookie['id'])));
            $donnes = $con->fetch(\PDO::FETCH_ASSOC);
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/user/updateuser.html.twig', ['user'=>$donnes,'access'=>$this->_usercookie['role']]);
            } else {
                $entitypost=new user($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $post['id']=$this->_usercookie['id'];
                    $this->_modelpost->updateuser(new user(($post)));
                    $con = $this->_modelpost->getuser(new user(array('id'=>$this->_usercookie['id'])));
                    $donnes = $con->fetch(\PDO::FETCH_ASSOC);
                    echo $this->twigenvi->render('/templates/user/updateuser.html.twig', ['alert'=>true,'user'=>$donnes,'access'=>$this->_usercookie['role']]);
                } else {
                    echo $this->twigenvi->render('/templates/user/updateuser.html.twig', ['checking'=>$checking,'user'=>$donnes,'access'=>$this->_usercookie['role']]);
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
        if (isset($this->_usercookie['id'])) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/user/updatepassword.html.twig', ['access'=>$this->_usercookie['role']]);
            } else {
                $con = $this->_modelpost->getuser(new user(array('id'=>$this->_usercookie['id'])));
                $donnes = $con->fetch(\PDO::FETCH_ASSOC);
                if (password_verify($post['oldpassword'], $donnes['mdp'])) {
                    $entitypost=new user(array('mdp'=>$post['newpassword'],'id'=>$this->_usercookie['id']));
                    $checking = $entitypost->isValid(array('mdp'=>$post['newpassword'],'id'=>$this->_usercookie['id']));
                    if (empty($checking)) {
                        $this->_modelpost->updatepassword($entitypost);
                        echo $this->twigenvi->render('/templates/user/updatepassword.html.twig', ['alert'=>'true','access'=>$this->_usercookie['role']]);
                    } else {
                        echo $this->twigenvi->render('/templates/user/updatepassword.html.twig', ['checking'=>$checking,'access'=>$this->_usercookie['role']]);
                    }
                } else {
                    echo $this->twigenvi->render('/templates/user/updatepassword.html.twig', ['alert'=>'false','access'=>$this->_usercookie['role']]);
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
}