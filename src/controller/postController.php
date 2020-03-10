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
namespace App\controller;

use App\twig\twigenvi;
use App\model\postmodel;
use App\model\entity;

/**
 * Class for managing post
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Postcontroller extends twigenvi
{
    private $_modelpost;
    private $_usercookie;
    /**
     * Init model and cookie
     */
    public function __construct()
    {
        parent::__construct();
        $this->modelpost = new postmodel;
        if (isset($_COOKIE['id'])) {
            $this->_usercookie['id'] = $_COOKIE['id'];
            $this->_usercookie['role'] = $_COOKIE['role'];
        }
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
            echo $this->twigenvi->render('/templates/home.html.twig', ['access'=>$this->_usercookie['role']]);
        } else {
            $recaptcha = new \ReCaptcha\ReCaptcha('6Lcchd8UAAAAANvIG5v94AgBnvVlY_nCf0jIdR14');
            $resp = $recaptcha->setExpectedHostname('localhost')
                ->verify($post['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if ($resp->isSuccess()) {
                mail('nobody@gmail.com', $post['prenom'].$post['nom'], $post['message'], 'From:'.$post['email']);
                echo '<script language="javascript">alert("Votre message viens d\'être envoyer !");window.location.replace("/")</script>';
            } else {
                echo '<script language="javascript">alert("Vous devez remplir le reCAPTCHA!");window.location.replace("/")</script>';
                $error = $resp->getErrorCodes();
                throw new \Exception($error);
            }
        } 
    }
    /**
     * Update post
     * 
     * @param integer $id   it's id post
     * @param array   $post it's post data
     * 
     * @return template
     */
    public function update($id,$post)
    {
        if (isset($this->_usercookie) && $this->_usercookie['role'] >= 2) {
            if (empty($post)) {
                $con = $this->modelpost->post(new entity(array('article_id'=>$id)));
                $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
                echo $this->twigenvi->render('/templates/post/postform.html.twig', ['url'=>'/updatepost/'.$id.'','donnes'=>$donnes,'access'=>$this->_usercookie['role']]);
            } else {
                $post['id']=$id;
                $this->modelpost->update(new entity($post));
                return header("LOCATION:/posts");
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Add post
     * 
     * @param array $post it's post data
     * 
     * @return template
     */
    public function add($post)
    {
        if (isset($this->_usercookie) && $this->_usercookie['role'] == 3) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/post/postform.html.twig', ['url'=>'addpost','access'=>$this->_usercookie['role']]);
            } else {
                $this->modelpost->add(new entity($post));
                return header("LOCATION:/posts");
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
        $con = $this->modelpost->post(new entity(array('article_id'=>$id)));
        $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
        $con1 = $this->modelpost->allcomment(new entity(array('article_id'=>$id)));
        $donnes1 = $con1->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/post/onepost.html.twig', ['nom'=>$donnes,'comment'=>$donnes1,'access'=>$this->_usercookie['role']]);
    }
    /**
     * Find all post
     * 
     * @return template
     */
    public function allposts()
    {
        $con = $this->modelpost->posts();
        $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/post/blogposts.html.twig', ['nom'=>$donnes,'access'=>$this->_usercookie['role']]);
    }
    /**
     * Remove post
     * 
     * @param integer $id it's id post
     * 
     * @return template
     */
    public function remove($id)
    {
        if (isset($this->_usercookie) && $this->_usercookie['role'] == 3) {
            $this->modelpost->remove(new entity(array('article_id'=>$id)));
            return header("LOCATION:/posts");
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
        if (isset($this->_usercookie)) {
            $recaptcha = new \ReCaptcha\ReCaptcha('6Lcchd8UAAAAANvIG5v94AgBnvVlY_nCf0jIdR14');
            $resp = $recaptcha->setExpectedHostname('localhost')
                ->verify($post['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if ($resp->isSuccess()) {
                $this->modelpost->addcomment(new entity(array('message'=>$post['contenu'],'user_id'=>$this->_usercookie['id'],'article_id'=>$post['id'])));
                echo '<script language="javascript">alert("Votre message viens d\'être envoyer et doit être valider pas les administrateurs!");window.location.replace("/post/'.$post['id'].'")</script>';
            } else {
                echo '<script language="javascript">alert("Vous devez remplir le reCAPTCHA!");window.location.replace("/post/'.$post['id'].'")</script>';
                $error = $resp->getErrorCodes();
                throw new \Exception($error);
            }
        } else {
            return header("LOCATION:/");
        }
    }
}
