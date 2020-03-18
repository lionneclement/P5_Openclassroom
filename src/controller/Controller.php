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

use App\Model\AuthentificationModel;
use App\Model\Adminmodel;
use App\Model\Postmodel;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Flash\Flash;
/**
 * Class for managing all controller file
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Controller
{
    /**
     * Init model and session
     */
    public function __construct()
    {
        $this->_modelPost = new Postmodel;
        $this->_modelAdmin = new Adminmodel;
        $this->_modelAuth = new AuthentificationModel;
        $this->superGlobal();
        $this->twigenvi();
        $this->filterPost();
    }
    /**
     * Init twig
     *
     * @return template
     */
    public function twigenvi()
    {
        $loader = new FilesystemLoader('../../src/view');
        $this->twigenvi = new Environment($loader);
    }
    /**
     * AddGlobal in twig
     *
     * @return template
     */
    public function twigFlash()
    {
        if (!empty($this->getSession('alert'))) {
            $alert = (new Flash())->getFlash();
            foreach ($alert as $key=>$value) {
                $this->twigenvi->addGlobal('alert_'.$key, $value);
            }
        }
        $sessionrole = $this->getSession('role');
        if (!empty($sessionrole)) {
            $this->twigenvi->addGlobal('user_access', $sessionrole);
        }
    }
    /**
     * Render the twig file with the parameters
     *
     * @param string $twigFile   The twig file
     * @param array  $parameters The parameters
     *
     * @return template
     */
    public function render(string $twigFile, array $parameters = [])
    {
        $this->twigFlash();
        try {
            print_r($this->twigenvi->render($twigFile, $parameters));
        } catch (\Exception $e) {
            return $e;
        }
    }
    /**
     * Render post secure
     *
     * @return template
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
     * Setter session
     *
     * @param string $key   The key
     * @param string $value The value
     * 
     * @return bool
     */
    public function setSession(string $key, $value)
    {
        $_SESSION[$key]=$value;
    }
    /**
     * Getter session
     *
     * @param string $key The key
     * 
     * @return bool
     */
    public function getSession(string $key)
    {
        if (!empty($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;   
    }
    /**
     * Delete session
     *
     * @param string $key The key
     * 
     * @return bool
     */
    public function deleteSession(string $key)
    {
        unset($_SESSION[$key]);
    }
    /**
     * Setup serverADDR
     *
     * @return session
     */
    public function superGlobal()
    {
        $this->serverADDR = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_SPECIAL_CHARS);
    }
}
