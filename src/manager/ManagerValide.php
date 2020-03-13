<?php
/** 
 * Function valide
 * 
 * PHP version 7.2.18
 * 
 * @category Entity
 * @package  Entity
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\entity;
use App\flash\Flash;
/** 
 * Function valide
 * 
 * PHP version 7.2.18
 * 
 * @category Entity
 * @package  Entity
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Valide
{
    protected $checking;
    /**
     * Check if it's valid
     * 
     * @param array $donnees all data
     * 
     * @return array
     */
    public function isValid(array $donnees)
    {
        $flash = new Flash();
        $this->checking=[];
        foreach ($donnees as $key => $value) {
            $method = 'get'.$key;
            if ($this->$method() == null) {
                $this->checking[$key]=$value;
            }
        }
        $flash->setFlash($this->checking);
        return $this->checking;
    }
}