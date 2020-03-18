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
     * @return template
     */
    public function register()
    {
        if (empty($this->getSession('id'))) {
            if (!empty($this->post)) {
                $donnes = $this->_modelAuth->check(new User($this->post));
                if (empty($donnes)) {
                    $this->_modelAuth->register(new User($this->post, 'post'));
                } else {
                    (new Flash())->setFlash(['already'=>'already']);
                }
            }
            return $this->render('/templates/authentication/register.html.twig');
        }
        return header("LOCATION:/");
    }
    /**
     * Login a user
     * 
     * @return template
     */
    public function login()
    {
        if (empty($this->getSession('id'))) {
            if (!empty($this->post)) {
                $donnes = $this->_modelAuth->check(new User($this->post, 'post'));
                if (empty($donnes)) {
                    (new Flash())->setFlash(['emailerror'=>'email']);
                } elseif (password_verify($this->post['mdp'], $donnes->mdp)) {
                    $this->confsession($donnes);
                    return header("LOCATION:/");
                } else {
                    (new Flash())->setFlash(['mdperror'=>'mdp']);
                }
            }
            return $this->render('/templates/authentication/login.html.twig');
        }
        return header("LOCATION:/");
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
        $this->setSession('id', $user->id);
        $this->setSession('role', $user->role_id);
    }
    /**
     * Send an email to be sure the user has the email and create a session
     * 
     * @return template
     */
    public function resetpassword()
    {
        if (!empty($this->post)) {
            $donnes = $this->_modelAuth->check(new User(['email'=>$this->post['email']]));
            if (empty($donnes)) {
                (new Flash())->setFlash(['emailfalse'=>'emailfalse']);
            } else {
                $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                shuffle($seed);
                $rand = '';
                foreach (array_rand($seed, 10) as $k) { 
                    $rand .= $seed[$k];
                }
                $obj = password_hash($rand, PASSWORD_DEFAULT);
                $this->setSession('reset', $obj);
                mail($this->post['email'], 'Changement de mot de passe', 'Voici le lien pour changer de mot de passe: http://localhost/auth/resetlink/'.$donnes->id.'/'.$rand);
                (new Flash())->setFlash(['emailtrue'=>'emailtrue']);
            }
        }
        return $this->render('/templates/authentication/reset.html.twig');
    }
    /**
     * Check if the session and the url match, if it's good reset password and delete session
     * 
     * @param integer $id  it's user id
     * @param string  $url it's the url
     * 
     * @return template
     */
    public function resetlink($id,$url)
    {
        if (!empty($this->getSession('reset')) && password_verify($url, $this->getSession('reset'))) {
            if (!empty($this->post)) {
                $entitypost=new User(['mdp'=>$this->post['newpassword'],'id'=>$id]);
                $checking = $entitypost->isValid(['mdp'=>$this->post['newpassword'],'id'=>$id]);
                if (empty($checking)) {
                    $this->_modelAuth->updatepassword($entitypost);
                    $this->deleteSession('reset');
                    (new Flash())->setFlash(['resetpassword'=>'resetpassword']);
                    return header("LOCATION:/auth/login");
                }
            }
            return $this->render('/templates/authentication/resetpassword.html.twig', ['url'=>$url,'id'=>$id]);
        }
        return header("LOCATION:/");
    }
}
