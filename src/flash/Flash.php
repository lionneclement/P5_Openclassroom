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
     * @return setter
     */
    public function setFlash($array)
    {
        if (empty($array)) {
            $this->setSession('alert', ['success'=>'success']);
        } else {
            $this->setSession('alert', $array);
        }
    }
    /**
     * Get and delete session
     * 
     * @return setter
     */
    public function getFlash()
    {
        if (!empty($this->getSession('alert'))) {
            $flash=$this->getSession('alert');
            $this->deleteSession('alert');   
        }
        return $flash;
    }
}