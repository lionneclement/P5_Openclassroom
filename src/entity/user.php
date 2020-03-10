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
namespace App\entity;
use App\entity\valide;
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
class User extends valide
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
     * Get id
     * 
     * @return variable
     */
    public function getid()
    {
        return $this->_id;
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
     * Get mdp
     * 
     * @return variable
     */
    public function getmdp()
    {
        return $this->_mdp;
    }
    /**
     * Get role id
     * 
     * @return variable
     */
    public function getroleId()
    {
        return $this->_roleId;
    }

    /**
     * Set id
     * 
     * @param Integer $id data
     * 
     * @return variable
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
     * Set mdp
     * 
     * @param Strign $mdp data
     * 
     * @return variable
     */
    public function setMdp($mdp)
    {
        if (is_string($mdp)) {
              $this->_mdp = password_hash($mdp, PASSWORD_DEFAULT);
        }
    }
    /**
     * Set role id
     * 
     * @param String $roleId data
     * 
     * @return variable
     */
    public function setRoleId($roleId)
    {
        $roleId = (int) $roleId;
        if ($roleId >= 1 && $roleId <= 3) {
            $this->_roleId = $roleId;
        }
    }
}
