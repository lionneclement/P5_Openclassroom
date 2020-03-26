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

use App\Manager\AuthentificationManager;
use App\Manager\UserManager;
use App\Manager\PostManager;
use App\Manager\CommentManager;
use App\Manager\PasswordManager;
use App\Manager\ConnectManager;
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
        $this->_manaPost = new PostManager;
        $this->_manaUser = new UserManager;
        $this->_manaAuth = new AuthentificationManager;
        $this->_manaComment = new CommentManager;
        $this->_manaPassword = new PasswordManager;
        $this->_manaConnect = new ConnectManager;
        $this->post = $this->filterPost();
    }
    /**
     * Render post secure
     *
     * @return array|null
     */
    public function filterPost()
    {
        $args = [
            'id' =>FILTER_SANITIZE_NUMBER_INT,
            'oldPassword'=>FILTER_SANITIZE_STRING,
            'newPassword'=>FILTER_SANITIZE_STRING,
            'password'=>FILTER_SANITIZE_STRING,
            'email'=> FILTER_SANITIZE_EMAIL,
            'firstName'=>FILTER_SANITIZE_STRING,
            'lastName'=>FILTER_SANITIZE_STRING,
            'g-recaptcha-response'=>FILTER_SANITIZE_STRING,
            'message'=>FILTER_SANITIZE_STRING,
            'content'=>FILTER_SANITIZE_STRING,
            'title'=>FILTER_SANITIZE_STRING,
            'extract'=>FILTER_SANITIZE_STRING,
            'userId'=>FILTER_SANITIZE_NUMBER_INT,
            'status'=>FILTER_SANITIZE_NUMBER_INT,
            'roleId'=>FILTER_SANITIZE_NUMBER_INT
        ];
        $this->post = filter_input_array(INPUT_POST, $args);
        if ($this->post !== null) {
            $this->post = array_filter($this->post, 'strlen');
        }
        return $this->post;
    }
    /**
     * Setup serverADDR
     *
     * @return string
     */
    public function superGlobal():string
    {
        return filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    /**
     * Init recaptcha
     * 
     * @param string $parameters it's the post
     * 
     * @return bool
     */
    public function recaptcha(string $parameters):bool
    {
        $recaptcha = new \ReCaptcha\ReCaptcha(getenv('RECAPTCHA'));
        $resp = $recaptcha->setExpectedHostname('localhost')
            ->verify($parameters, $this->superGlobal());
        return $resp->isSuccess();
    }
    /**
     * Generate an random word
     * 
     * @param int $numberCharacter it's the number of character
     * 
     * @return string
     */
    public function randomWord(int $numberCharacter):string
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
