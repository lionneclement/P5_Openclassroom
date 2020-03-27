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
class Post
{
    private $_id;
    private $_title;
    private $_extract;
    private $_content;
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
     * Get id
     * 
     * @return int
     */
    public function getId():int
    {
        return $this->_id;
    }
    /**
     * Get title
     * 
     * @return string
     */
    public function getTitle():string
    {
        return $this->_title;
    }
    /**
     * Get extract
     * 
     * @return string
     */
    public function getExtract():string
    {
        return $this->_extract;
    }/**
      * Get content
      * 
      * @return string
      */
    public function getContent():string
    {
        return $this->_content;
    }
    /**
     * Get user id
     * 
     * @return int
     */
    public function getUserId():int
    {
        return $this->_userId;
    }
    /**
     * Set id
     * 
     * @param integer $id data
     * 
     * @return void
     */
    public function setId($id):void
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
     * @return void
     */
    public function setTitle($title):void
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
     * @return void
     */
    public function setExtract($extract):void
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
     * @return void
     */
    public function setContent($content):void
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
     * @return void
     */
    public function setUserId($userId):void
    {
        $userId = (int) $userId;
        if ($userId > 0) {
            $this->_userId = $userId;
        }
    }
}
