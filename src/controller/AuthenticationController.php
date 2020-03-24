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
     * @return void
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
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Login a user
     * 
     * @return void
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
                    return $this->render("/templates/error.html.twig");
                } else {
                    (new Flash())->setFlash(['mdperror'=>'mdp']);
                }
            }
            return $this->render('/templates/authentication/login.html.twig');
        }
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Logout a user
     * 
     * @return void
     */
    public function logout()
    {
        session_unset();
        return $this->render("/templates/error.html.twig");
    }
    /**
     * Create session
     * 
     * @param array $user it's user id and user role
     * 
     * @return void
     */
    public function confSession(object $user)
    {
        $this->setSession('id', $user->id);
        $this->setSession('role', $user->role_id);
    }
    /**
     * Send an email to be sure the user has the email and create a session
     * 
     * @return void
     */
    public function resetPassword()
    {
        if (!empty($this->post)) {
            $donnes = $this->_modelAuth->check(new User(['email'=>$this->post['email']]));
            if (empty($donnes)) {
                (new Flash())->setFlash(['emailfalse'=>'emailfalse']);
            } else {
                $rand = $this->randomWord(10);
                $obj = password_hash($rand, PASSWORD_DEFAULT);
                $this->setSession('reset', $obj);
                $text = "<html><body>
                Voici le lien pour changer de mot de passe:
                <a href='http://localhost/auth/resetlink/$donnes->id/$rand'
                target='_blank'>Votre lien:</a>
                </body></html>";
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                mail($this->post['email'], 'Changement de mot de passe', $text, $headers);
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
     * @return void
     */
    public function resetLink(int $id,string $url)
    {
        if (!empty($this->getSession('reset')) && password_verify($url, $this->getSession('reset'))) {
            if (!empty($this->post)) {
                $entitypost=new User(['mdp'=>$this->post['newpassword'],'id'=>$id], 'post');
                $this->_modelAuth->updatePassword($entitypost);
                $this->deleteSession('reset');
            }
            return $this->render('/templates/authentication/resetpassword.html.twig', ['url'=>$url,'id'=>$id]);
        }
        return $this->render("/templates/error.html.twig");
    }
}
