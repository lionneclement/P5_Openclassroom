<?php
/** 
 * Getter and Setter for article
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
/** 
 * Getter and Setter for article
 * 
 * PHP version 7.2.18
 * 
 * @category Entity
 * @package  Entity
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Article
{
    private $_id;
    private $_titre;
    private $_chapo;
    private $_contenu;
    private $_userId;
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
     * Get title
     * 
     * @return variable
     */
    public function gettitre()
    {
        return $this->_titre;
    }
    /**
     * Get chapo
     * 
     * @return variable
     */
    public function getchapo()
    {
        return $this->_chapo;
    }/**
      * Get content
      * 
      * @return variable
      */
    public function getcontenu()
    {
        return $this->_contenu;
    }
    /**
     * Get user id
     * 
     * @return variable
     */
    public function getuserId()
    {
        return $this->_userId;
    }
    /**
     * Set id
     * 
     * @param integer $id data
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
     * Set title
     * 
     * @param String $titre data
     * 
     * @return variable
     */
    public function setTitre($titre)
    {
        if (is_string($titre) && strlen($titre) <= 30) {
            $this->_titre = $titre;
        }
    }
    /**
     * Set chapo
     * 
     * @param String $chapo data
     * 
     * @return variable
     */
    public function setChapo($chapo)
    {
        if (is_string($chapo) && strlen($chapo) <= 255) {
            $this->_chapo = $chapo;
        }
    }
    /**
     * Set Contenu
     * 
     * @param String $contenu data
     * 
     * @return variable
     */
    public function setContenu($contenu)
    {
        if (is_string($contenu)) {
            $this->_contenu = $contenu;
        }
    }
    /**
     * Set user id
     * 
     * @param integer $userId data
     * 
     * @return variable
     */
    public function setUserId($userId)
    {
        $userId = (int) $userId;
        if ($userId > 0) {
            $this->_userId = $userId;
        }
    }
}