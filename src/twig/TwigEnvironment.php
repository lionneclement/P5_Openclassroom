<?php
/** 
 * The file it's for init twig
 * 
 * PHP version 7.2.18
 * 
 * @category Twig
 * @package  Twig
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\flash\Flash;
/** 
 * This it's for init twig
 * 
 * PHP version 7.2.18
 * 
 * @category Twig
 * @package  Twig
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Twigenvi
{
    /**
     * Init twig
     */
    public function __construct()
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
}