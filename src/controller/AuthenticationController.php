<?php
/** 
 * The file is for authentification
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
use App\model\AuthentificationModel;
use App\entity\user;
use App\flash\Flash;
/**
 * Class for authentification
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class AuthentificationController extends twigenvi
{
    private $_modelpost;
    private $_usersession;
    /**
     * Init model and session
     */
    public function __construct()
    {
        parent::__construct();
        $this->_modelpost = new AuthentificationModel;
        if (isset($_SESSION['id'])) {
            $this->_usersession['id'] = $_SESSION['id'];
            $this->_usersession['role'] = $_SESSION['role'];
        }
    }
    /**
     * Register a user
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function register($post)
    {
        if (!isset($this->_usersession)) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/authentication/register.html.twig');
            } else {
                $entitypost=new user($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $con = $this->_modelpost->check($entitypost);
                    $donnes = $con->fetchAll();
                    $flash = new Flash();
                    if (empty($donnes)) {
                        $flash->setFlash(array());
                        $this->_modelpost->register($entitypost);
                        return header("LOCATION:/auth/register");
                    } else {
                        $flash->setFlash(array('already'=>'already'));
                        return header("LOCATION:/auth/register");
                    }
                } else {
                    return header("LOCATION:/auth/register");
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Login a user
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function login($post)
    {
        if (!isset($this->_usersession)) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/authentication/login.html.twig');
            } else {
                $entitypost=new user($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $con = $this->_modelpost->check($entitypost);
                    $donnes = $con->fetch(\PDO::FETCH_OBJ);
                    $flash = new Flash();
                    if (password_verify($post['mdp'], $donnes->mdp)) {
                        $this->confsession($donnes);
                        return header("LOCATION:/");
                    } elseif (!empty($donnes)) {
                        $flash->setFlash(array('mdperror'=>'mdp'));
                        return header("LOCATION:/auth/login");
                    } else {
                        $flash->setFlash(array('emailerror'=>'email'));
                        return header("LOCATION:/auth/login");
                    }
                } else {
                    return header("LOCATION:/auth/login");
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Logout a user
     * 
     * @return template
     */
    public function logout()
    {
        session_unset();
        return header("LOCATION:/");
    }
    /**
     * Create session
     * 
     * @param array $user it's user id and user role
     * 
     * @return template
     */
    public function confsession($user)
    {
        $_SESSION['id']= $user->id;
        $_SESSION['role']= $user->role_id;
    }
    /**
     * Send an email to be sure the user has the email and create a session
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function resetpassword($post)
    {
        if (empty($post)) {
            echo $this->twigenvi->render('/templates/authentication/reset.html.twig');
        } else {
            $con = $this->_modelpost->check(new user(array('email'=>$post['email'])));
            $donnes = $con->fetch(\PDO::FETCH_OBJ);
            $flash = new Flash();
            if (empty($donnes)) {
                $flash->setFlash(array('emailfalse'=>'emailfalse'));
                return header("LOCATION:/auth/resetpassword");
            } else {
                $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                shuffle($seed);
                $rand = '';
                foreach (array_rand($seed, 10) as $k) { 
                    $rand .= $seed[$k];
                }
                $obj = password_hash($rand, PASSWORD_DEFAULT);
                $_SESSION['reset']=$obj;
                mail($post['email'], 'Changement de mot de passe', 'Voici le lien pour changer de mot de passe: http://localhost/auth/resetlink/'.$donnes->id.'/'.$rand);
                $flash->setFlash(array('emailtrue'=>'emailtrue'));
                return header("LOCATION:/auth/resetpassword");
            }
        }
    }
    /**
     * Check if the session and the url match, if it's good reset password and delete session
     * 
     * @param integer $id   it's user id
     * @param string  $url  it's the url
     * @param array   $post it's user data
     * 
     * @return template
     */
    public function resetlink($id,$url,$post)
    {
        if (isset($_SESSION['reset']) && password_verify($url, $_SESSION['reset'])) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/authentication/resetpassword.html.twig', ['url'=>$url,'id'=>$id,'access'=>$this->_usersession['role']]);
            } else {
                $entitypost=new user(array('mdp'=>$post['newpassword'],'id'=>$id));
                $checking = $entitypost->isValid(array('mdp'=>$post['newpassword'],'id'=>$id));
                if (empty($checking)) {
                    $this->_modelpost->updatepassword($entitypost);
                    unset($_SESSION['reset']);
                    $flash = new Flash();
                    $flash->setFlash(array('resetpassword'=>'resetpassword'));
                    return header("LOCATION:/auth/login");
                } else {
                    return header("LOCATION:/auth/resetlink/$id/$url");
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
}