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
use App\Entity\Commentaire;
use App\Manager\CommentManager;

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
        if ($this->getSession('role') == 3) {
            $donnes = (new CommentManager)->findAllComment();
            return $this->render('/templates/comment/comment.html.twig', ['url'=>'allcomment','comment'=>$donnes]);
        }
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Find all invalide comment
     * 
     * @return void
     */
    public function findAllInvalideComment()
    {
        if ($this->getSession('role') == 3) {
            $donnes = (new CommentManager)->findAllInvalideComment();
            return $this->render('/templates/comment/comment.html.twig', ['url'=>'allinvalidecomment','comment'=>$donnes]);
        }
        return $this->render("/templates/error.html.twig");
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
        if ($this->getSession('role') == 3 && !empty($id)) {
            (new CommentManager)->updateComment(new Commentaire($this->post, 'post'));
            header("Location: /admin/$url");
        }
        return $this->render("/templates/error.html.twig");
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
        if ($this->getSession('role') == 3 && !empty($id)) {
            (new CommentManager)->removeComment(new Commentaire(['id'=>$id]));
            header("Location: /admin/$url");
        }
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Add comment in contact form
     * 
     * @return void
     */
    public function addComment()
    {
        if (!empty($this->getSession('id'))) {
            if ($this->recaptcha($this->post['g-recaptcha-response'])) {
                $entitypost=new Commentaire(['message'=>$this->post['contenu'],'userId'=>$this->getSession('id'),'articleId'=>$this->post['id']], 'post');
                (new CommentManager)->addComment($entitypost);
                header("Location: /post/findOne/".$this->post['id']."#addcomment");
            }
            return $this->render("/templates/error.html.twig");
        }
    }
}
