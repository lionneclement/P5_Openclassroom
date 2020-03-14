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
     * Get message
     * 
     * @return variable
     */
    public function getmessage()
    {
        return $this->_message;
    }
    /**
     * Get statut
     * 
     * @return variable
     */
    public function getstatut()
    {
        return $this->_statut;
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
     * Get article id
     * 
     * @return variable
     */
    public function getarticleId()
    {
        return $this->_articleId;
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
    /**
     * Set statut
     * 
     * @param String $statut data
     * 
     * @return variable
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
     * @return variable
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
     * @return variable
     */
    public function setArticleId($articleId)
    {
        $articleId = (int) $articleId;
        if ($articleId > 0) {
            $this->_articleId = $articleId;
        }
    }
}
