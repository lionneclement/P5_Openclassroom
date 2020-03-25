<?php
/** 
 * Getter and Setter for commentaire
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
 * Getter and Setter for commentaire
 * 
 * PHP version 7.2.18
 * 
 * @category Entity
 * @package  Entity
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Commentaire extends Valide
{
    private $_id;
    private $_message;
    private $_statut;
    private $_userId;
    private $_articleId;
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
     * Get message
     * 
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }
    /**
     * Get statut
     * 
     * @return int
     */
    public function getStatut()
    {
        return $this->_statut;
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
     * Get article id
     * 
     * @return int
     */
    public function getArticleId()
    {
        return $this->_articleId;
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
     * Set Message
     * 
     * @param String $message data
     * 
     * @return null
     */
    public function setMessage($message)
    {
        if (is_string($message) && strlen($message) <= 250) {
            $this->_message = $message;
        }
    }
    /**
     * Set statut
     * 
     * @param String $statut data
     * 
     * @return null
     */
    public function setStatut($statut)
    {
        $statut = (int) $statut;
        if ($statut == 0 || $statut == 1) {
            $this->_statut = $statut;
        }
    }
    /**
     * Set user id
     * 
     * @param Integer $userId data
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
    /**
     * Set article id
     * 
     * @param Integer $articleId data
     * 
     * @return null
     */
    public function setArticleId($articleId)
    {
        $articleId = (int) $articleId;
        if ($articleId > 0) {
            $this->_articleId = $articleId;
        }
    }
}
