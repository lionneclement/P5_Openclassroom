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
use App\Entity\Valide;
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
class Contact extends Valide
{
    private $_lastName;
    private $_firstName;
    private $_email;
    private $_message;
    /**
     * Call hydrate
     * 
     * @param array  $data all data
     * @param string $post just an string 
     */
    public function __construct(array $data =[],string $post=null)
    {
        if (!empty($data)) {
            $this->hydrate($data);
            if ($post) {
                $this->isValid($data);
            }
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
     * Get message
     * 
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
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
     * Set Message
     * 
     * @param String $message data
     * 
     * @return null
     */
    public function setMessage($message)
    {
        if (is_string($message)) {
            $this->_message = $message;
        }
    }
}
