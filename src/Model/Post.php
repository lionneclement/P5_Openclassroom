<?php
/** 
 * Getter and Setter for post
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
 * Getter and Setter for post
 * 
 * PHP version 7.2.18
 * 
 * @category Entity
 * @package  Entity
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Post extends Valide
{
    private $_id;
    private $_title;
    private $_extract;
    private $_content;
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
    public function getId()
    {
        return $this->_id;
    }
    /**
     * Get title
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }
    /**
     * Get extract
     * 
     * @return string
     */
    public function getExtract()
    {
        return $this->_extract;
    }/**
      * Get content
      * 
      * @return string
      */
    public function getContent()
    {
        return $this->_content;
    }
    /**
     * Get user id
     * 
     * @return int
     */
    public function getUserId()
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
     * @param String $title data
     * 
     * @return null
     */
    public function setTitle($title)
    {
        if (is_string($title) && strlen($title) <= 30) {
            $this->_title = $title;
        }
    }
    /**
     * Set extract
     * 
     * @param String $extract data
     * 
     * @return null
     */
    public function setExtract($extract)
    {
        if (is_string($extract) && strlen($extract) <= 255) {
            $this->_extract = $extract;
        }
    }
    /**
     * Set content
     * 
     * @param String $content data
     * 
     * @return null
     */
    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
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
