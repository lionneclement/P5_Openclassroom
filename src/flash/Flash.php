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
    private $_sessionalert;
    /**
     * Init session alert
     */
    public function __construct()
    {
        $this->_sessionalert = &$_SESSION['alert'];
    }
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
            $this->_sessionalert=['success'=>'success'];
        } else {
            $this->_sessionalert=$array;
        }
    }
    /**
     * Get and delete session
     * 
     * @return setter
     */
    public function getFlash()
    {
        if (isset($this->_sessionalert)) {
            $flash=$this->_sessionalert;
            $this->_sessionalert=null;
            return $flash;
        }
        return null;
    }
}