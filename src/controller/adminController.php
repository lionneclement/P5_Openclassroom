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
use App\Entity\Article;
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
     * Page admin
     * 
     * @return void
     */
    public function admin()
    {
        if ($this->getSession('role') == 3) {
            return $this->render('/templates/user/admin.html.twig');
        }
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Show comment valid and comment invalid
     * 
     * @param string $type The param is to know if the comment is to be created or modified
     * 
     * @return void
     */
    public function comment($type)
    {
        if ($this->getSession('role') == 3) {
            if (!empty($this->post)) {
                $this->_modelAdmin->updateComment(new Commentaire($this->post, 'post'));
            }
            $donnes = $this->_modelAdmin->$type();
            return $this->render('/templates/user/comment.html.twig', ['return'=>$type,'comment'=>$donnes]);
        }
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Delete comment
     * 
     * @param integer $id  it's id comment
     * @param array   $url the paramis here to find out in which url was doing the deletion
     * 
     * @return void
     */
    public function deleteComment($id,$url)
    {
        if ($this->getSession('role') == 3 && !empty($id)) {
            $this->_modelAdmin->deleteComment(new Commentaire(['id'=>$id]));
            return $this->comment($url);
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
    public function deleteUser($id)
    {
        if ($this->getSession('role') == 3 && !empty($id)) {
            $Post = $this->_modelAdmin->findAllPosts(new User(['id'=>$id]));
            foreach ($Post as $value) {
                $this->_modelAdmin->deleteAllCommentWithArticleid(new Article(['id'=>$value->id]));
            };
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
     /**
      * Update the password with the old password
      * 
      * @return void
      */
    public function updatepassword()
    {
        if (!empty($this->getSession('id'))) {
            if (!empty($this->post)) {
                $donnes = $this->_modelAdmin->getUser(new User(['id'=>$this->getSession('id')]));
                if (password_verify($this->post['oldpassword'], $donnes->mdp)) {
                    $this->_modelAdmin->updatePassword(new User(['mdp'=>$this->post['newpassword'],'id'=>$this->getSession('id')], 'post'));
                } else {
                    (new Flash())->setFlash(['danger'=>'danger']);
                }
            }
            return $this->render('/templates/user/updatepassword.html.twig');
        }
        return $this->render("/templates/error.html.twig");
    }
}