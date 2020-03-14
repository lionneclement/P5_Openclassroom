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
namespace App\Model;

use App\Model\Connectmodel;
use App\Entity\User;
/**
 * Class for retrieve authentification information from the database
 * 
 * @category Model
 * @package  Model
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
     * @return data
     */
    public function check(User $post)
    {
        $sql = $this->bdd->query("SELECT * FROM user WHERE email='".$post->getemail()."'"); 
        return $sql->fetch(\PDO::FETCH_OBJ);
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
        $this->bdd->prepare($sql)->execute(['nom'=>$post->getnom(),'prenom'=>$post->getprenom(),'email'=>$post->getemail(),'mdp'=>$post->getmdp()]);
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
        $this->bdd->prepare($sql)->execute(['mdp'=>$post->getmdp(),'id'=>$post->getid()]);
    }
}