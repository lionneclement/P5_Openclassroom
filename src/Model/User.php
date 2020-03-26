<?php
/** 
 * Getter and Setter for user
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
/** 
 * Getter and Setter for user
 * 
 * PHP version 7.2.18
 * 
 * @category Entity
 * @package  Entity
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class User
{
    private $_id;
    private $_lastName;
    private $_firstName;
    private $_email;
    private $_password;
    private $_roleId;
    /**
     * Call hydrate
     * 
     * @param array $data all data
     */
    public function __construct(array $data =[])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }
    /**
     * Hydrate variable
     * 
     * @param array $donnees all data
     * 
     * @return void
     */
    public function hydrate(array $donnees):void
    {
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
    /**
     * Get id
     * 
     * @return int
     */
    public function getId():int
    {
        return $this->_id;
    }
    /**
     * Get lastName
     * 
     * @return string
     */
    public function getLastName():string
    {
        return $this->_lastName;
    }
    /**
     * Get firstName
     * 
     * @return string
     */
    public function getFirstName():string
    {
        return $this->_firstName;
    }
    /**
     * Get email
     * 
     * @return string
     */
    public function getEmail():string
    {
        return $this->_email;
    }
    /**
     * Get password
     * 
     * @return string
     */
    public function getPassword():string
    {
        return $this->_password;
    }
    /**
     * Get role id
     * 
     * @return int
     */
    public function getRoleId():int
    {
        return $this->_roleId;
    }

    /**
     * Set id
     * 
     * @param Integer $id data
     * 
     * @return void
     */
    public function setId($id):void
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }
    /**
     * Set lastName
     * 
     * @param String $lastName data
     * 
     * @return void
     */
    public function setLastName($lastName):void
    {
        if (is_string($lastName) && strlen($lastName) <= 30) {
            $this->_lastName = $lastName;
        }
    }
    /**
     * Set firstName
     * 
     * @param String $firstName data
     * 
     * @return void
     */
    public function setFirstName($firstName):void
    {
        if (is_string($firstName) && strlen($firstName) <= 30) {
            $this->_firstName = $firstName;
        }
    }
    /**
     * Set Email
     * 
     * @param String $email data
     * 
     * @return void
     */
    public function setEmail($email):void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $this->_email = $email;
        }
    }
    /**
     * Set password
     * 
     * @param Strign $password data
     * 
     * @return void
     */
    public function setPassword($password):void
    {
        if (is_string($password) && strlen($password)>=13) {
              $this->_password = password_hash($password, PASSWORD_DEFAULT);
        }
    }
    /**
     * Set role id
     * 
     * @param String $roleId data
     * 
     * @return void
     */
    public function setRoleId($roleId):void
    {
        $roleId = (int) $roleId;
        if ($roleId >= 1 && $roleId <= 3) {
            $this->_roleId = $roleId;
        }
    }
}
