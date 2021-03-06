<?php
/** 
 * Getter and Setter for comment
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
 * Getter and Setter for comment
 * 
 * PHP version 7.2.18
 * 
 * @category Entity
 * @package  Entity
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Comment
{
    private $_id;
    private $_message;
    private $_status;
    private $_userId;
    private $_postId;
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
     * Get message
     * 
     * @return string
     */
    public function getMessage():string
    {
        return $this->_message;
    }
    /**
     * Get status
     * 
     * @return int
     */
    public function getStatus():int
    {
        return $this->_status;
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
     * Get post id
     * 
     * @return int
     */
    public function getPostId():int
    {
        return $this->_postId;
    }
    /**
     * Set id
     * 
     * @param Integer $id data
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
     * Set Message
     * 
     * @param String $message data
     * 
     * @return void
     */
    public function setMessage($message):void
    {
        if (is_string($message) && strlen($message) <= 250) {
            $this->_message = $message;
        }
    }
    /**
     * Set status
     * 
     * @param String $status data
     * 
     * @return void
     */
    public function setStatus($status):void
    {
        $status = (int) $status;
        if ($status == 0 || $status == 1) {
            $this->_status = $status;
        }
    }
    /**
     * Set user id
     * 
     * @param Integer $userId data
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
    /**
     * Set post id
     * 
     * @param Integer $postId data
     * 
     * @return void
     */
    public function setPostId($postId):void
    {
        $postId = (int) $postId;
        if ($postId > 0) {
            $this->_postId = $postId;
        }
    }
}
