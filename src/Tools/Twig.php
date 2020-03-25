<?php
/** 
 * The file is for managing Twig
 * 
 * PHP version 7.2.18
 * 
 * @category Tools
 * @package  Tools
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\Tools;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class is for managing Twig
 * 
 * @category Tools
 * @package  Tools
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Twig
{
    /**
     * Init twigenvi
     */
    public function __construct()
    {
        $this->twigEnvi();
    }
    /**
     * Init twig environment
     *
     * @return void
     */
    public function twigEnvi()
    {
        $loader = new FilesystemLoader('../../src/view');
        $this->twigenvi = new Environment($loader);
    }
    /**
     * Render the twig file with the parameters
     *
     * @param string $twigFile   The twig file
     * @param array  $parameters The parameters
     *
     * @return void
     */
    public function render(string $twigFile, array $parameters = [])
    {
        $this->userAccess();
        try {
            print_r($this->twigenvi->render($twigFile, $parameters));
        } catch (\Exception $e) {
            return $e;
        }
    }
    /**
     * Init Twig access
     *
     * @return void
     */
    public function userAccess()
    {
        $sessionrole = Session::getSession('role');
        if (!empty($sessionrole)) {
            $this->twigenvi->addGlobal('user_access', $sessionrole);
        }
    }
}