<?php
/** 
 * Getter and Setter for contact
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
 * Getter and Setter for contact
 * 
 * PHP version 7.2.18
 * 
 * @category Entity
 * @package  Entity
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Contact
{
    private $_lastName;
    private $_firstName;
    private $_email;
    private $_message;
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
     * Get message
     * 
     * @return string
     */
    public function getMessage():string
    {
        return $this->_message;
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
     * Set Message
     * 
     * @param String $message data
     * 
     * @return void
     */
    public function setMessage($message):void
    {
        if (is_string($message)) {
            $this->_message = $message;
        }
    }
}
