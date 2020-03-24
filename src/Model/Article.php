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
namespace App\Entity;
use App\Entity\Valide;
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
class Article extends Valide
{
    private $_id;
    private $_titre;
    private $_chapo;
    private $_contenu;
    private $_userId;
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
    public function getid()
    {
        return $this->_id;
    }
    /**
     * Get title
     * 
     * @return string
     */
    public function gettitre()
    {
        return $this->_titre;
    }
    /**
     * Get chapo
     * 
     * @return string
     */
    public function getchapo()
    {
        return $this->_chapo;
    }/**
      * Get content
      * 
      * @return string
      */
    public function getcontenu()
    {
        return $this->_contenu;
    }
    /**
     * Get user id
     * 
     * @return int
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
     * Set title
     * 
     * @param String $titre data
     * 
     * @return null
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
     * @return null
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
     * @return null
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
     * @return null
     */
    public function setUserId($userId)
    {
        $userId = (int) $userId;
        if ($userId > 0) {
            $this->_userId = $userId;
        }
    }
}