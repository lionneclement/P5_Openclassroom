<?php
/** 
 * The file is for CRUD password
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
use App\Tools\Session;
/**
 * Class is for CRUD password
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class PasswordController extends Controller
{
    /**
     * Init controller
     */
    public function __construct()
    {
        parent::__construct();
    }
     /**
      * Update the password with the old password
      * 
      * @return void
      */
    public function updatePassword()
    {
        if (!empty(Session::getSession('id'))) {
            if (!empty($this->post)) {
                $donnes = $this->_manaUser->findUserWithId(new User(['id'=>Session::getSession('id')]));
                if (password_verify($this->post['oldPassword'], $donnes->password)) {
                    $this->_manaPassword->updatePassword(new User(['password'=>$this->post['newPassword'],'id'=>Session::getSession('id')]));
                    Session::setSession('alert', 'success');
                } else {
                    Session::setSession('alert', 'password');
                }
            }
            return $this->twig->render('/templates/password/updatepassword.html.twig');
        }
        return $this->twig->render("/templates/error.html.twig");
    }
    /**
     * Send an email to be sure the user has the email and create a session
     * 
     * @return void
     */
    public function sendLinkForResetPassword()
    {
        if (!empty($this->post)) {
            $donnes = $this->_manaAuth->check(new User(['email'=>$this->post['email']]));
            if (empty($donnes)) {
                Session::setSession('alert', 'emailError');
            } else {
                $rand = $this->randomWord(10);
                $obj = password_hash($rand, PASSWORD_DEFAULT);
                Session::setSession('reset', $obj);
                $text = "<html><body>
                Voici le lien pour changer de mot de passe:
                <a href='http://localhost/password/reset/$donnes->id/$rand'
                target='_blank'>Votre lien:</a>
                </body></html>";
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                mail($this->post['email'], 'Changement de mot de passe', $text, $headers);
                Session::setSession('alert', 'success');
            }
        }
        return $this->twig->render('/templates/password/sendlink.html.twig');
    }
    /**
     * Check if session and the url match, if it's good reset password and delete session
     * 
     * @param integer $id  it's user id
     * @param string  $url it's the url
     * 
     * @return void
     */
    public function resetPassword(int $id,string $url)
    {
        if (!empty(Session::getSession('reset')) && password_verify($url, Session::getSession('reset'))) {
            if (!empty($this->post)) {
                $entitypost=new User(['password'=>$this->post['newPassword'],'id'=>$id]);
                $this->_manaPassword->updatePassword($entitypost);
                Session::deleteSession('reset');
                Session::setSession('alert', 'changePassword');
                $this->redirect('/auth/login');
            }
            return $this->twig->render('/templates/password/resetpassword.html.twig', ['url'=>$url,'id'=>$id]);
        }
        return $this->twig->render("/templates/error.html.twig");
    }
}
