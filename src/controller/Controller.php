<?php
/** 
 * The file is for managing all controller file
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

use App\Manager\AuthentificationModel;
use App\Manager\Adminmodel;
use App\Manager\Postmodel;
use App\Flash\Flash;
use App\Tools\Session;
use App\Tools\Twig;
/**
 * Class for managing all controller file
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
abstract class Controller
{
    /**
     * Init manager
     */
    public function __construct()
    {
        $this->twig = new Twig();
        $this->_modelPost = new Postmodel;
        $this->_modelAdmin = new Adminmodel;
        $this->_modelAuth = new AuthentificationModel;
        $this->superGlobal();
        $this->filterPost();
    }
    /**
     * AddGlobal in twig
     *
     * @return void
     */
    public function twigFlash()
    {
        if (!empty(Session::getSession('alert'))) {
            $alert = (new Flash())->getFlash();
            foreach ($alert as $key=>$value) {
                $this->twigenvi->addGlobal('alert_'.$key, $value);
            }
        }
    }
    /**
     * Render post secure
     *
     * @return array
     */
    public function filterPost()
    {
        $args = [
            'id' =>FILTER_SANITIZE_NUMBER_INT,
            'oldpassword'=>FILTER_SANITIZE_STRING,
            'newpassword'=>FILTER_SANITIZE_STRING,
            'mdp'=>FILTER_SANITIZE_STRING,
            'email'=> FILTER_SANITIZE_EMAIL,
            'nom'=>FILTER_SANITIZE_STRING,
            'prenom'=>FILTER_SANITIZE_STRING,
            'g-recaptcha-response'=>FILTER_SANITIZE_STRING,
            'message'=>FILTER_SANITIZE_STRING,
            'contenu'=>FILTER_SANITIZE_STRING,
            'titre'=>FILTER_SANITIZE_STRING,
            'chapo'=>FILTER_SANITIZE_STRING,
            'userId'=>FILTER_SANITIZE_NUMBER_INT,
            'statut'=>FILTER_SANITIZE_NUMBER_INT,
            'roleId'=>FILTER_SANITIZE_NUMBER_INT
        ];
        $this->post = filter_input_array(INPUT_POST, $args);
        if ($this->post !== null) {
            $this->post = array_filter($this->post, 'strlen');
        }
    }
    /**
     * Setup serverADDR
     *
     * @return null
     */
    public function superGlobal()
    {
        $this->serverADDR = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    /**
     * Init recaptcha
     * 
     * @param string $parameters it's the post
     * 
     * @return bool
     */
    public function recaptcha(string $parameters)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha(getenv('RECAPTCHA'));
        $resp = $recaptcha->setExpectedHostname('localhost')
            ->verify($parameters, $this->serverADDR);
        (new Flash())->setFlash(['reCAPTCHA'=>'reCAPTCHA']);
        return $resp->isSuccess();
    }
    /**
     * Generate an random word
     * 
     * @param int $numberCharacter it's the number of character
     * 
     * @return string
     */
    public function randomWord(int $numberCharacter)
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, $numberCharacter) as $k) { 
            $rand .= $seed[$k];
        }
        return $rand;
    }
}
