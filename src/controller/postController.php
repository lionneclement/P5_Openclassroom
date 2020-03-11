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
use App\entity\contact;
use App\entity\article;
use App\entity\Commentaire;

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
        $this->_modelpost = new postmodel;
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
                unset($post['g-recaptcha-response']);
                $entitypost=new contact($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    mail('nobody@gmail.com', $post['prenom'].$post['nom'], $post['message'], 'From:'.$post['email']);
                    echo $this->twigenvi->render('/templates/home.html.twig', ['alert'=>'success','access'=>$this->_usercookie['role']]);
                } else {
                    echo $this->twigenvi->render('/templates/home.html.twig', ['alert'=>$checking,'access'=>$this->_usercookie['role']]);
                }
            } else {
                echo $this->twigenvi->render('/templates/home.html.twig', ['alert'=>'reCAPTCHA','access'=>$this->_usercookie['role']]);
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
        $usersql = $this->_modelpost->findAlluser();
        $donnesUser = $usersql->fetchAll(\PDO::FETCH_ASSOC);
        if (isset($this->_usercookie) && $this->_usercookie['role'] == 3 && $id==null) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/post/addUpdatepost.html.twig', ['select'=>$this->_usercookie['id'],'Auteur'=>$donnesUser,'url'=>'addpost','access'=>$this->_usercookie['role']]);
            } else {
                $entitypost=new article($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $this->_modelpost->add($entitypost);
                    return header("LOCATION:/post/findAll");
                } else { 
                    echo $this->twigenvi->render('/templates/post/addUpdatepost.html.twig', ['select'=>$this->_usercookie['id'],'Auteur'=>$donnesUser,'addAlert'=>$checking,'url'=>'addpost','access'=>$this->_usercookie['role']]);
                }
            }
        } elseif (isset($this->_usercookie) && $this->_usercookie['role'] >= 2) {
            $con = $this->_modelpost->post(new article(array('id'=>$id)));
            $donnes = $con->fetch(\PDO::FETCH_ASSOC);
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/post/addUpdatepost.html.twig', ['select'=>$donnes['user_id'],'Auteur'=>$donnesUser,'url'=>'updatepost/'.$id.'','donnes'=>$donnes,'access'=>$this->_usercookie['role']]);
            } else {
                $entitypost=new article($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $post['id']=$id;
                    $this->_modelpost->update(new article($post));
                    $con = $this->_modelpost->post(new article(array('id'=>$id)));
                    $donnes = $con->fetch(\PDO::FETCH_ASSOC);
                    echo $this->twigenvi->render('/templates/post/addUpdatepost.html.twig', ['select'=>$donnes['user_id'],'Auteur'=>$donnesUser,'alert'=>'success','url'=>'updatepost/'.$id.'','donnes'=>$donnes,'access'=>$this->_usercookie['role']]);
                } else { 
                    echo $this->twigenvi->render('/templates/post/addUpdatepost.html.twig', ['select'=>$donnes['user_id'],'Auteur'=>$donnesUser,'addAlert'=>$checking,'url'=>'updatepost/'.$id.'','donnes'=>$donnes,'access'=>$this->_usercookie['role']]);
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Update post
     * 
     * @param integer $id    it's id post
     * @param string  $error it's a string
     * 
     * @return template
     */
    public function onepost($id,$error=null)
    {
        $con = $this->_modelpost->post(new Article(array('id'=>$id)));
        $donnes = $con->fetch(\PDO::FETCH_ASSOC);
        $con1 = $this->_modelpost->allcomment(new Article(array('id'=>$id)));
        $donnes1 = $con1->fetchAll(\PDO::FETCH_ASSOC);
        $con2 = $this->_modelpost->findUser($donnes['user_id']);
        $donnes2 = $con2->fetch(\PDO::FETCH_ASSOC);
        foreach ($donnes1 as $key => $value) {
            $con3 = $this->_modelpost->findUser($value['user_id']);
            $donnes3 = $con3->fetch(\PDO::FETCH_ASSOC);
            $donnes1[$key]['nom']=$donnes3['nom'];
        }
        $donnes['user_id']=$donnes2['nom'];
        echo $this->twigenvi->render('/templates/post/onepost.html.twig', ['alert'=>$error,'nom'=>$donnes,'comment'=>$donnes1,'access'=>$this->_usercookie['role']]);
    }
    /**
     * Find all post
     * 
     * @return template
     */
    public function allposts()
    {
        $con = $this->_modelpost->posts();
        $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->twigenvi->render('/templates/post/blogposts.html.twig', ['nom'=>array_reverse($donnes),'access'=>$this->_usercookie['role']]);
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
        if (isset($this->_usercookie) && $this->_usercookie['role'] == 3) {
            $this->_modelpost->remove(new article(array('id'=>$id)));
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
        if (isset($this->_usercookie)) {
            $recaptcha = new \ReCaptcha\ReCaptcha('6Lcchd8UAAAAANvIG5v94AgBnvVlY_nCf0jIdR14');
            $resp = $recaptcha->setExpectedHostname('localhost')
                ->verify($post['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if ($resp->isSuccess()) {
                $entitypost=new Commentaire(array('message'=>$post['contenu'],'userId'=>$this->_usercookie['id'],'articleId'=>$post['id']));
                $checking = $entitypost->isValid(array('message'=>$post['contenu'],'userId'=>$this->_usercookie['id'],'articleId'=>$post['id']));
                if (empty($checking)) {
                    $this->_modelpost->addcomment($entitypost);
                    $this->onepost($post['id'], 'success');
                } else {
                    $this->onepost($post['id'], 'commentaire');
                }
            } else {
                $this->onepost($post['id'], 'recaptcha');
            }
        } else {
            return header("LOCATION:/");
        }
    }
}
