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
namespace App\Entity;
use App\Flash\Flash;
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
        $this->checking=[];
        foreach ($donnees as $key => $value) {
            $method = 'get'.$key;
            if ($this->$method()===null) {
                $this->checking[$key]=$value;
            }
        }
        (new Flash())->setFlash($this->checking);
        return $this->checking;
    }
}