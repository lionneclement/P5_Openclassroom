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
    private $_nom;
    private $_prenom;
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
     * Get nom
     * 
     * @return string
     */
    public function getNom()
    {
        return $this->_nom;
    }
    /**
     * Get prenom
     * 
     * @return string
     */
    public function getPrenom()
    {
        return $this->_prenom;
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
     * Set nom
     * 
     * @param String $nom data
     * 
     * @return null
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
     * @return null
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
