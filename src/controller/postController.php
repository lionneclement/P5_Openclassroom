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
     * @param array $post it's post data
     * 
     * @return template
     */
    public function home($post)
    {
        if (empty($post)) {
            return $this->render('/templates/home.html.twig');
        } else {
            $recaptcha = new \ReCaptcha\ReCaptcha('6Lcchd8UAAAAANvIG5v94AgBnvVlY_nCf0jIdR14');
            $resp = $recaptcha->setExpectedHostname('localhost')
                ->verify($post['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            (new Flash())->setFlash(['reCAPTCHA'=>'reCAPTCHA']);
            if ($resp->isSuccess()) {
                unset($post['g-recaptcha-response']);
                $entitypost=new Contact($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    mail('nobody@gmail.com', $post['prenom'].' '.$post['nom'], $post['message'], 'From:'.$post['email']);
                    return header("LOCATION:/#contact");
                } else {
                    return header("LOCATION:/#contact");
                }
            } else {
                return header("LOCATION:/#contact");
            }
        } 
    }
    /**
     * Update and add  post
     * 
     * @param array   $post it's post data
     * @param integer $id   it's id post
     * 
     * @return template
     */
    public function addUpdate($post,$id=null)
    {   
        $donnesUser = $this->_modelPost->findAlluser();
        if ($this->_usersession['role'] == 3 && $id==null) {
            if (empty($post)) {
                return $this->render('/templates/post/addUpdatepost.html.twig', ['select'=>$this->_usersession['id'],'Auteur'=>$donnesUser,'url'=>'addpost']);
            } else {
                $entitypost=new Article($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $this->_modelPost->add($entitypost);
                    return header("LOCATION:/post/findAll");
                } else { 
                    return header("LOCATION:/post/addpost");
                }
            }
        } elseif ($this->_usersession['role'] >= 2) {
            $donnes = $this->_modelPost->post(new Article(['id'=>$id]));
            if (empty($post)) {
                return $this->render('/templates/post/addUpdatepost.html.twig', ['select'=>$donnes->user_id,'Auteur'=>$donnesUser,'url'=>'updatepost/'.$id.'','donnes'=>$donnes]);
            } else {
                $post['id']=$id;
                $this->_modelPost->update(new Article($post, 'post'));
                return header("LOCATION:/post/updatepost/$id");
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Update post
     * 
     * @param integer $id it's id post
     * 
     * @return template
     */
    public function onepost($id)
    {
        $donnes = $this->_modelPost->post(new Article(['id'=>$id]));
        $donnes1 = $this->_modelPost->allcomment(new Article(['id'=>$id]));
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
     * @return template
     */
    public function allposts()
    {
        $donnes = $this->_modelPost->posts();
        return $this->render('/templates/post/blogposts.html.twig', ['nom'=>$donnes]);
    }
    /**
     * Remove one post
     * 
     * @param integer $id it's id post
     * 
     * @return template
     */
    public function remove($id)
    {
        if ($this->_usersession['role'] == 3) {
            $this->_modelPost->remove(new Article(['id'=>$id]));
            return header("LOCATION:/post/findAll");
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Add comment in one post
     * 
     * @param array $post it's post data
     * 
     * @return template
     */
    public function commentPost($post)
    {
        if (isset($this->_usersession['id'])) {
            $recaptcha = new \ReCaptcha\ReCaptcha('6Lcchd8UAAAAANvIG5v94AgBnvVlY_nCf0jIdR14');
            $resp = $recaptcha->setExpectedHostname('localhost')
                ->verify($post['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            (new Flash())->setFlash(['reCAPTCHA'=>'reCAPTCHA']);
            if ($resp->isSuccess()) {
                $entitypost=new Commentaire(['message'=>$post['contenu'],'userId'=>$this->_usersession['id'],'articleId'=>$post['id']], 'post');
                $this->_modelPost->addcomment($entitypost);
            }
                return header('LOCATION:/post/findOne/'.$post['id'].'#addcomment');
        } else {
            return header("LOCATION:/");
        }
    }
}
