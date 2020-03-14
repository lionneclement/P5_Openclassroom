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

use App\Twig\Twigenvi;
use App\Model\Postmodel;
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
class Postcontroller extends Twigenvi
{
    private $_modelpost;
    private $_usersession;
    /**
     * Init model and session
     */
    public function __construct()
    {
        parent::__construct();
        $this->_modelpost = new Postmodel;
        $this->_usersession['id'] = &$_SESSION['id'];
        $this->_usersession['role'] = &$_SESSION['role'];
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
            $flash = new Flash();
            $flash->setFlash(['reCAPTCHA'=>'reCAPTCHA']);
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
        $donnesUser = $this->_modelpost->findAlluser();
        if ($this->_usersession['role'] == 3 && $id==null) {
            if (empty($post)) {
                return $this->render('/templates/post/addUpdatepost.html.twig', ['select'=>$this->_usersession['id'],'Auteur'=>$donnesUser,'url'=>'addpost']);
            } else {
                $entitypost=new Article($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $this->_modelpost->add($entitypost);
                    return header("LOCATION:/post/findAll");
                } else { 
                    return header("LOCATION:/post/addpost");
                }
            }
        } elseif ($this->_usersession['role'] >= 2) {
            $donnes = $this->_modelpost->post(new Article(['id'=>$id]));
            if (empty($post)) {
                return $this->render('/templates/post/addUpdatepost.html.twig', ['select'=>$donnes->user_id,'Auteur'=>$donnesUser,'url'=>'updatepost/'.$id.'','donnes'=>$donnes]);
            } else {
                $entitypost=new Article($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $post['id']=$id;
                    $this->_modelpost->update(new Article($post));
                    return header("LOCATION:/post/updatepost/$id");
                } else { 
                    return header("LOCATION:/post/updatepost/$id");
                }
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
        $donnes = $this->_modelpost->post(new Article(['id'=>$id]));
        $donnes1 = $this->_modelpost->allcomment(new Article(['id'=>$id]));
        $donnes2 = $this->_modelpost->findUser($donnes->user_id);
        foreach ($donnes1 as $key => $value) {
            $donnes3 = $this->_modelpost->findUser($value->user_id);
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
        $donnes = $this->_modelpost->posts();
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
            $this->_modelpost->remove(new Article(['id'=>$id]));
            return header("LOCATION:/post/findAll");
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Update post
     * 
     * @param array $post it's post data
     * 
     * @return template
     */
    public function comment($post)
    {
        if (isset($this->_usersession['id'])) {
            $recaptcha = new \ReCaptcha\ReCaptcha('6Lcchd8UAAAAANvIG5v94AgBnvVlY_nCf0jIdR14');
            $resp = $recaptcha->setExpectedHostname('localhost')
                ->verify($post['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            $flash = new Flash();
            $flash->setFlash(['reCAPTCHA'=>'reCAPTCHA']);
            if ($resp->isSuccess()) {
                $entitypost=new Commentaire(['message'=>$post['contenu'],'userId'=>$this->_usersession['id'],'articleId'=>$post['id']]);
                $checking = $entitypost->isValid(['message'=>$post['contenu']]);
                if (empty($checking)) {
                    $this->_modelpost->addcomment($entitypost);
                    return header('LOCATION:/post/findOne/'.$post['id'].'#addcomment');
                } else {
                    return header('LOCATION:/post/findOne/'.$post['id'].'#addcomment');
                }
            } else {
                return header('LOCATION:/post/findOne/'.$post['id'].'#addcomment');
            }
        } else {
            return header("LOCATION:/");
        }
    }
}
