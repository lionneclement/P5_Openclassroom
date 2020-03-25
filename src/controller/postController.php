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
use App\Entity\Contact;
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
            if ($this->recaptcha($this->post['g-recaptcha-response'])) {
                unset($this->post['g-recaptcha-response']);
                $checking = (new Contact($this->post, 'post'));
                if (empty($checking->checking)) {
                    mail('nobody@gmail.com', $this->post['firstName'].' '.$this->post['lastName'], $this->post['message'], 'From:'.$this->post['email']);
                }
            }
        }
        return $this->twig->render('/templates/home.html.twig');
    }
    /**
     * Update and add post
     * 
     * @param integer $id it's id post
     * 
     * @return void
     */
    public function addUpdate(int $id=null)
    {   
        $donnesUser = $this->_modelPost->findAllUser();
        if (Session::getSession('role') == 3 && $id==null) {
            if (!empty($this->post)) {
                $entitypost=new Post($this->post, 'post');
                $this->_modelPost->add($entitypost);
            }
            return $this->twig->render('/templates/post/addUpdatepost.html.twig', ['select'=>Session::getSession('id'),'Auteur'=>$donnesUser,'url'=>'addpost']);
        } if (Session::getSession('role') >= 2) {
            if (!empty($this->post)) {
                $this->post['id']=$id;
                $this->_modelPost->update(new Post($this->post, 'post'));
            }
            $donnes = $this->_modelPost->post(new Post(['id'=>$id]));
            return $this->twig->render('/templates/post/addUpdatepost.html.twig', ['select'=>$donnes->userId,'Auteur'=>$donnesUser,'url'=>'updatepost/'.$id.'','donnes'=>$donnes]);
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
        }
        return $this->allposts();
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
