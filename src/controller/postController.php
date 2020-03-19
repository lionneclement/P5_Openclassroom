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
use App\Entity\Article;
use App\Entity\Commentaire;
use App\Flash\Flash;

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
                $checking = (new Contact($this->post))->isValid($this->post);
                if (empty($checking)) {
                    mail('nobody@gmail.com', $this->post['prenom'].' '.$this->post['nom'], $this->post['message'], 'From:'.$this->post['email']);
                }
            }
        }
        return $this->render('/templates/home.html.twig');
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
        if ($this->getSession('role') == 3 && $id==null) {
            if (!empty($this->post)) {
                $entitypost=new Article($this->post, 'post');
                $this->_modelPost->add($entitypost);
            }
            return $this->render('/templates/post/addUpdatepost.html.twig', ['select'=>$this->getSession('id'),'Auteur'=>$donnesUser,'url'=>'addpost']);
        } if ($this->getSession('role') >= 2) {
            if (!empty($this->post)) {
                $this->post['id']=$id;
                $this->_modelPost->update(new Article($this->post, 'post'));
            }
            $donnes = $this->_modelPost->post(new Article(['id'=>$id]));
            return $this->render('/templates/post/addUpdatepost.html.twig', ['select'=>$donnes->user_id,'Auteur'=>$donnesUser,'url'=>'updatepost/'.$id.'','donnes'=>$donnes]);
        }
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Update post
     * 
     * @param integer $id it's id post
     * 
     * @return void
     */
    public function onePost($id)
    {
        $donnes = $this->_modelPost->post(new Article(['id'=>$id]));
        $donnes1 = $this->_modelPost->allComment(new Article(['id'=>$id]));
        $donnes2 = $this->_modelPost->findUser($donnes->user_id);
        foreach ($donnes1 as $key => $value) {
            $donnes3 = $this->_modelPost->findUser($value->user_id);
            $donnes1[$key]->nom=$donnes3->nom;
        }
        $donnes->nom=$donnes2->nom;
        return $this->render('/templates/post/onepost.html.twig', ['nom'=>$donnes,'comment'=>$donnes1]);
    }
    /**
     * Find all post
     * 
     * @return void
     */
    public function allPosts()
    {
        $donnes = $this->_modelPost->posts();
        return $this->render('/templates/post/blogposts.html.twig', ['nom'=>$donnes]);
    }
    /**
     * Remove one post
     * 
     * @param integer $id it's id post
     * 
     * @return void
     */
    public function remove($id)
    {
        if ($this->getSession('role') == 3) {
            $this->_modelPost->remove(new Article(['id'=>$id]));
        }
        return $this->allposts();
    }
    /**
     * Add comment in one post
     * 
     * @return void
     */
    public function commentPost()
    {
        if (!empty($this->getSession('id'))) {
            if ($this->recaptcha($this->post['g-recaptcha-response'])) {
                $entitypost=new Commentaire(['message'=>$this->post['contenu'],'userId'=>$this->getSession('id'),'articleId'=>$this->post['id']], 'post');
                $this->_modelPost->addComment($entitypost);
                return $this->onepost($this->post['id']);
            }
            return $this->render("/templates/error.html.twig");
        }
    }
}
