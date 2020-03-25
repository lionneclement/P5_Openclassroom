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
     * @return null
     */
    public function hydrate(array $donnees)
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
    public function getId()
    {
        return $this->_id;
    }
    /**
     * Get lastName
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->_lastName;
    }
    /**
     * Get firstName
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }
    /**
     * Get email
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }
    /**
     * Get password
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }
    /**
     * Get role id
     * 
     * @return int
     */
    public function getRoleId()
    {
        return $this->_roleId;
    }

    /**
     * Set id
     * 
     * @param Integer $id data
     * 
     * @return null
     */
    public function setId($id)
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
     * @return null
     */
    public function setLastName($lastName)
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
     * @return null
     */
    public function setFirstName($firstName)
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
     * @return null
     */
    public function setEmail($email)
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
     * @return null
     */
    public function setPassword($password)
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
     * @return null
     */
    public function setRoleId($roleId)
    {
        $roleId = (int) $roleId;
        if ($roleId >= 1 && $roleId <= 3) {
            $this->_roleId = $roleId;
        }
    }
}
