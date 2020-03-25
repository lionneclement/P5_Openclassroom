<?php
/** 
 * The file is for CRUD comment
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
use App\Entity\Comment;
use App\Manager\CommentManager;
use App\Tools\Session;

/**
 * Class for CRUD comment
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

class CommentController extends Controller
{
    /**
     * Init manager and session
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Find all comment
     * 
     * @return void
     */
    public function findAllComment()
    {
        if (Session::getSession('role') == 3) {
            $donnes = (new CommentManager)->findAllComment();
            return $this->twig->render('/templates/comment/comment.html.twig', ['url'=>'allcomment','comment'=>$donnes]);
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Find all invalide comment
     * 
     * @return void
     */
    public function findAllInvalideComment()
    {
        if (Session::getSession('role') == 3) {
            $donnes = (new CommentManager)->findAllInvalideComment();
            return $this->twig->render('/templates/comment/comment.html.twig', ['url'=>'allinvalidecomment','comment'=>$donnes]);
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Update comment
     * 
     * @param integer $id  it's id comment
     * @param string  $url it's the url
     * 
     * @return void
     */
    public function updateComment(int $id,string $url)
    {
        if (Session::getSession('role') == 3 && !empty($id)) {
            (new CommentManager)->updateComment(new Comment($this->post));
            Session::setSession('alert', 'update');
            header("Location: /admin/$url");
            exit;
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Remove comment
     * 
     * @param integer $id  it's id comment
     * @param string  $url it's the url
     * 
     * @return void
     */
    public function removeComment(int $id,string $url)
    {
        if (Session::getSession('role') == 3 && !empty($id)) {
            (new CommentManager)->removeComment(new Comment(['id'=>$id]));
            Session::setSession('alert', 'remove');
            header("Location: /admin/$url");
            exit;
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Add comment in contact form
     * 
     * @return void
     */
    public function addComment()
    {
        if (!empty(Session::getSession('id'))) {
            if (!empty($this->post['g-recaptcha-response']) && $this->recaptcha($this->post['g-recaptcha-response'])) {
                $entitypost=new Comment(['message'=>$this->post['content'],'userId'=>Session::getSession('id'),'postId'=>$this->post['id']]);
                (new CommentManager)->addComment($entitypost);
                Session::setSession('alert', 'success');
            } else {
                Session::setSession('alert', 'reCAPTCHA');   
            }
            header("Location: /post/findOne/".$this->post['id']."#addcomment");
            exit;
        }
        return $this->twig->render("/templates/error.html.twig");
    }
}
