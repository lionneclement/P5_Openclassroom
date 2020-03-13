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
namespace App\flash;

use Closure;

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

class Flash
{
    /**
     * Set session
     * 
     * @param array $array it's array
     * 
     * @return setter
     */
    public function setFlash($array)
    {
        if (empty($array)) {
            $_SESSION['alert']=['success'=>'success'];
        } else {
            $_SESSION['alert']=$array;
        }
    }
    /**
     * Get and delete session
     * 
     * @param array $key all data
     * 
     * @return setter
     */
    public function getFlash()
    {
        if (isset($_SESSION['alert'])) {
            $flash=$_SESSION['alert'];
            unset($_SESSION['alert']);
            return $flash;
        }
        return null;
    }
}