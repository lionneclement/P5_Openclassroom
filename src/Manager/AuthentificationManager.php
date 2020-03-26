<?php
/** 
 * The file is for retrieve authentification information from the database
 * 
 * PHP version 7.2.18
 * 
 * @category Manager
 * @package  Manager
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\Manager;

use App\Manager\ConnectManager;
use App\Entity\User;
/**
 * Class for retrieve authentification information from the database
 * 
 * @category Manager
 * @package  Manager
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class AuthentificationManager extends ConnectManager
{
    /**
     * Check if the user exist
     * 
     * @param array $post it's user data
     * 
     * @return object
     */
    public function check(User $post)
    {
        $sql = $this->bdd->prepare("SELECT * FROM user WHERE email=?");
        $sql->execute([$post->getEmail()]);
        return $sql->fetch(\PDO::FETCH_OBJ);
    }
    /**
     * Register a user
     * 
     * @param array $post it's user data
     * 
     * @return void
     */
    public function register(User $post):void
    {
        $sql = 'INSERT INTO user (id, lastName, firstName, email, password, roleId) 
    VALUES (NULL,?,?,?,?,1)';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getLastName(),$post->getFirstName(),$post->getEmail(),$post->getPassword()]);
    }
}
