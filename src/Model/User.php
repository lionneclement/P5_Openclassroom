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
use App\Entity\Valide;
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
class User extends Valide
{
    private $_id;
    private $_nom;
    private $_prenom;
    private $_email;
    private $_mdp;
    private $_roleId;
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
     * Get id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
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
     * Get mdp
     * 
     * @return string
     */
    public function getMdp()
    {
        return $this->_mdp;
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
     * Set mdp
     * 
     * @param Strign $mdp data
     * 
     * @return null
     */
    public function setMdp($mdp)
    {
        if (is_string($mdp) && strlen($mdp)>=13) {
              $this->_mdp = password_hash($mdp, PASSWORD_DEFAULT);
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
