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
namespace App\Controller;

use App\Controller\Controller;
use App\Entity\User;
use App\Flash\Flash;
/**
 * Class for authentification
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class AuthentificationController extends Controller
{
    /**
     * Init controller
     */
    public function __construct()
    {
        parent::__construct();
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
        if (!isset($this->_usersession['id'])) {
            if (empty($post)) {
                return $this->render('/templates/authentication/register.html.twig');
            } else {
                $entitypost=new User($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $donnes = $this->_modelAuth->check($entitypost);
                    $flash = new Flash();
                    if (empty($donnes)) {
                        $flash->setFlash([]);
                        $this->_modelAuth->register($entitypost);
                        return header("LOCATION:/auth/register");
                    } else {
                        $flash->setFlash(['already'=>'already']);
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
        if (!isset($this->_usersession['id'])) {
            if (empty($post)) {
                return $this->render('/templates/authentication/login.html.twig');
            } else {
                $entitypost=new User($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $donnes = $this->_modelAuth->check($entitypost);
                    $flash = new Flash();
                    if (password_verify($post['mdp'], $donnes->mdp)) {
                        $this->confsession($donnes);
                        return header("LOCATION:/");
                    } elseif (!empty($donnes)) {
                        $flash->setFlash(['mdperror'=>'mdp']);
                        return header("LOCATION:/auth/login");
                    } else {
                        $flash->setFlash(['emailerror'=>'email']);
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
        $this->_usersession['id']= $user->id;
        $this->_usersession['role']= $user->role_id;
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
            return $this->render('/templates/authentication/reset.html.twig');
        } else {
            $donnes = $this->_modelAuth->check(new User(['email'=>$post['email']]));
            $flash = new Flash();
            if (empty($donnes)) {
                $flash->setFlash(['emailfalse'=>'emailfalse']);
                return header("LOCATION:/auth/resetpassword");
            } else {
                $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                shuffle($seed);
                $rand = '';
                foreach (array_rand($seed, 10) as $k) { 
                    $rand .= $seed[$k];
                }
                $obj = password_hash($rand, PASSWORD_DEFAULT);
                $this->_usersession['reset']=$obj;
                mail($post['email'], 'Changement de mot de passe', 'Voici le lien pour changer de mot de passe: http://localhost/auth/resetlink/'.$donnes->id.'/'.$rand);
                $flash->setFlash(['emailtrue'=>'emailtrue']);
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
        if (isset($this->_usersession['reset']) && password_verify($url, $this->_usersession['reset'])) {
            if (empty($post)) {
                return $this->render('/templates/authentication/resetpassword.html.twig', ['url'=>$url,'id'=>$id]);
            } else {
                $entitypost=new User(['mdp'=>$post['newpassword'],'id'=>$id]);
                $checking = $entitypost->isValid(['mdp'=>$post['newpassword'],'id'=>$id]);
                if (empty($checking)) {
                    $this->_modelAuth->updatepassword($entitypost);
                    $this->_usersession['reset']=null;
                    $flash = new Flash();
                    $flash->setFlash(['resetpassword'=>'resetpassword']);
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