<?php
/** 
 * The file is for managing post
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
use App\Entity\Post;
use App\Manager\CommentManager;
use App\Tools\Session;

/**
 * Class for managing post
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Postcontroller extends Controller
{
    /**
     * Init controller
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Home page
     * 
     * @return void
     */
    public function home()
    {
        if (!empty($this->post)) {
            if (!empty($this->post['g-recaptcha-response']) && $this->recaptcha($this->post['g-recaptcha-response'])) {
                mail('nobody@gmail.com', $this->post['firstName'].' '.$this->post['lastName'], $this->post['message'], 'From:'.$this->post['email']);
                Session::setSession('alert', 'success');
            } else {
                Session::setSession('alert', 'reCAPTCHA');
            }
        }
        return $this->twig->render('/templates/home.html.twig');
    }
    /**
     * Add post
     * 
     * @return void
     */
    public function addPost()
    {
        if (Session::getSession('role') == 3) {
            if (!empty($this->post)) {
                $this->_modelPost->add(new Post($this->post));
                Session::setSession('alert', 'success_add');
            }
            $donnesUser = $this->_modelPost->findAllUser();
            return $this->twig->render('/templates/post/addUpdatepost.html.twig', ['select'=>Session::getSession('id'),'users'=>$donnesUser,'url'=>'addpost']);
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Update post
     * 
     * @param integer $id it's id post
     * 
     * @return void
     */
    public function updatePost(int $id)
    {   
        
        if (Session::getSession('role') >= 2) {
            if (!empty($this->post)) {
                $this->post['id']=$id;
                $this->_modelPost->update(new Post($this->post));
                Session::setSession('alert', 'success_update');
            }
            $donnes = $this->_modelPost->post(new Post(['id'=>$id]));
            $donnesUser = $this->_modelPost->findAllUser();
            return $this->twig->render('/templates/post/addUpdatepost.html.twig', ['select'=>$donnes->userId,'users'=>$donnesUser,'url'=>'updatepost/'.$id.'','donnes'=>$donnes]);
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * One post
     * 
     * @param int $id it's id post
     * 
     * @return void
     */
    public function onePost(int $id)
    {
        $post = $this->_modelPost->post(new Post(['id'=>$id]));
        $comment = (new CommentManager)->findAllPostComment(new Post(['id'=>$id]));
        return $this->twig->render('/templates/post/onepost.html.twig', ['post'=>$post,'comment'=>$comment]);
    }
    /**
     * Find all post
     * 
     * @return void
     */
    public function allPosts()
    {
        $donnes = $this->_modelPost->posts();
        return $this->twig->render('/templates/post/blogposts.html.twig', ['post'=>$donnes]);
    }
    /**
     * Remove one post
     * 
     * @param int $id it's id post
     * 
     * @return void
     */
    public function remove(int $id)
    {
        if (Session::getSession('role') == 3) {
            $this->_modelPost->remove(new Post(['id'=>$id]));
            Session::setSession('alert', 'remove');
        }
        header("Location:/post/findAll");
        exit;
    }
    /**
     * Return error 404 page
     * 
     * @return void
     */
    public function error404()
    {
        return $this->twig->render("/templates/error.html.twig");
    }
}
