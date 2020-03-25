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

use App\Manager\Connectmodel;
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
class AuthentificationModel extends Connectmodel
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
     * @return null
     */
    public function register(User $post)
    {
        $sql = 'INSERT INTO user (id, nom, prenom, email, mdp, role_id) 
    VALUES (NULL,?,?,?,?,1)';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getNom(),$post->getPrenom(),$post->getEmail(),$post->getMdp()]);
    }
}