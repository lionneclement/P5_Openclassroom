<?php
/** 
 * The file is for retrieve authentification information from the database
 * 
 * PHP version 7.2.18
 * 
 * @category Model
 * @package  Model
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\model;

use App\model\connectmodel;
use App\entity\User;
/**
 * Class for retrieve authentification information from the database
 * 
 * @category Model
 * @package  Model
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class AuthentificationModel extends connectmodel
{
    /**
     * Check if the user exist
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function check(User $post)
    {
        return $this->bdd->query("SELECT * FROM user WHERE email='".$post->getemail()."'"); 
    }
    /**
     * Register a user
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function register(User $post)
    {
        $sql = 'INSERT INTO user (id, nom, prenom, email, mdp, role_id) 
    VALUES (NULL,:nom,:prenom,:email,:mdp,1)';
        $this->bdd->prepare($sql)->execute(array('nom'=>$post->getnom(),'prenom'=>$post->getprenom(),'email'=>$post->getemail(),'mdp'=>$post->getmdp()));
    }
    /**
     * Update password
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function updatepassword(User $post)
    {
        $sql = 'UPDATE user SET mdp=:mdp WHERE id=:id';
        $this->bdd->prepare($sql)->execute(array('mdp'=>$post->getmdp(),'id'=>$post->getid()));
    }
}