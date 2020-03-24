<?php 

/** 
 * The file is for managing flash notification
 * 
 * PHP version 7.2.18
 * 
 * @category Flash
 * @package  Flash
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\Flash;

use App\Controller\Controller;
use App\Tools\Session;
/** 
 * Class for managing flash notification
 * 
 * PHP version 7.2.18
 * 
 * @category Flash
 * @package  Flash
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

class Flash extends Controller
{
    /**
     * Set session
     * 
     * @param array $array it's array
     * 
     * @return null
     */
    public function setFlash(array $array)
    {
        if (empty($array)) {
            Session::setSession('alert', ['success'=>'success']);
        } else {
            Session::setSession('alert', $array);
        }
    }
    /**
     * Get and delete session
     * 
     * @return array
     */
    public function getFlash()
    {
        if (!empty(Session::getSession('alert'))) {
            $flash=Session::getSession('alert');
            Session::deleteSession('alert');   
        }
        return $flash;
    }
}