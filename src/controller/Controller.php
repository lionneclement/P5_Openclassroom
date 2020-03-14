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
        $this->_usersession['id'] = &$_SESSION['id'];
        $this->_usersession['role'] = &$_SESSION['role'];
        $this->_usersession['reset'] = &$_SESSION['reset'];
        $this->twigenvi();
    }
    /**
     * Render the twig file with the parameters
     *
     * @return template
     */
    public function twigenvi()
    {
        $loader = new FilesystemLoader('../../src/view');
        $flash = new Flash();
        $this->twigenvi = new Environment($loader);
        $sessionalert = &$_SESSION['alert'];
        if (isset($sessionalert)) {
            $alert = $flash->getFlash();
            foreach ($alert as $key=>$value) {
                $this->twigenvi->addGlobal('alert_'.$key, $value);
            }
        }
        $sessionrole = &$_SESSION['role'];
        if (isset($sessionrole)) {
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
        try {
            echo $this->twigenvi->render($twigFile, $parameters);
        } catch (\Exception $e) {
            return $e;
        }
    }
}