<?php
/** 
 * The file is for home page
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
use App\Tools\Session;

/**
 * Class for home page
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class HomeController extends Controller
{
    /**
     * Home page
     * 
     * @return void
     */
    public function home()
    {
        if (!empty($this->post)) {
            if (!empty($this->post['g-recaptcha-response']) && $this->recaptcha($this->post['g-recaptcha-response'])) {
                mail('nobody@gmail.com', $this->post['firstName'].' '.$this->post['lastName'], $this->post['message'], 'From:'.$this->post['email']);
                Session::setSession('alert', 'success');
            } else {
                Session::setSession('alert', 'reCAPTCHA');
            }
        }
        return $this->twig->render('/templates/home.html.twig');
    }
}
