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
namespace App\entity;
use App\entity\valide;
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
class Contact extends valide
{
    private $_nom;
    private $_prenom;
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
     * @return setter
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
     * Get nom
     * 
     * @return variable
     */
    public function getnom()
    {
        return $this->_nom;
    }
    /**
     * Get prenom
     * 
     * @return variable
     */
    public function getprenom()
    {
        return $this->_prenom;
    }
    /**
     * Get email
     * 
     * @return variable
     */
    public function getemail()
    {
        return $this->_email;
    }
    /**
     * Get message
     * 
     * @return variable
     */
    public function getmessage()
    {
        return $this->_message;
    }

    
    /**
     * Set nom
     * 
     * @param String $nom data
     * 
     * @return variable
     */
    public function setNom($nom)
    {
        if (is_string($nom) && strlen($nom) <= 30) {
            $this->_nom = $nom;
        }
    }
    /**
     * Set prenom
     * 
     * @param String $prenom data
     * 
     * @return variable
     */
    public function setPrenom($prenom)
    {
        if (is_string($prenom) && strlen($prenom) <= 30) {
            $this->_prenom = $prenom;
        }
    }
    /**
     * Set Email
     * 
     * @param String $email data
     * 
     * @return variable
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
     * @return variable
     */
    public function setMessage($message)
    {
        if (is_string($message)) {
            $this->_message = $message;
        }
    }
}
