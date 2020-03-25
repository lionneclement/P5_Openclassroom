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
        $this->addGlobal('role', false);
        $this->addGlobal('alert', true);
        try {
            print_r($this->twigenvi->render($twigFile, $parameters));
        } catch (\Exception $e) {
            return $e;
        }
    }
    /**
     * Create global variable
     *
     * @param string $keySession The session key
     * @param bool   $delete     If delete session or not
     * 
     * @return void
     */
    public function addGlobal(string $keySession, bool $delete)
    {
        $session = Session::getSession($keySession);
        if ($delete) {
            Session::deleteSession($keySession);
        }
        if (!empty($session)) {
            $this->twigenvi->addGlobal($keySession, $session);
        }
    }
}