<?php
/** 
 * The file is for retrieve admin information from the database
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
 * Class for retrieve admin information from the database
 * 
 * @category Model
 * @package  Model
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Adminmodel extends connectmodel
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
     * Get all user without us
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function roles(entity $post)
    {
        return $this->bdd->query('SELECT * FROM user WHERE NOT id='.$post->getuser_id().''); 
    }
    /**
     * Update role
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function updaterole(entity $post)
    {
        $sql = 'UPDATE user SET role_id=:role_id WHERE id=:id';
        $this->bdd->prepare($sql)->execute(array('role_id'=>$post->getrole_id(),'id'=>$post->getid()));
    }
    /**
     * Get all comment
     * 
     * @return data
     */
    public function allcomment()
    {
        return $this->bdd->query('SELECT * FROM commentaire');
    }
    /**
     * Update comment
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function updatecomment(entity $post)
    {
        $sql = 'UPDATE commentaire SET statut=:statut WHERE id=:id';
        $this->bdd->prepare($sql)->execute(array('statut'=>$post->getstatut(),'id'=>$post->getid()));
    }
    /**
     * Get all comment invalid
     * 
     * @return data
     */
    public function invalidecomment()
    {
        return $this->bdd->query('SELECT * FROM commentaire WHERE statut=0');
    }
    /**
     * Delete comment
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function deletecomment(entity $post)
    {
        $this->bdd->query('DELETE FROM commentaire WHERE id='.$post->getid().'');
    }
    /**
     * Get one post
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function getpost(entity $post)
    {
        return $this->bdd->query('SELECT * FROM article WHERE user_id='.$post->getuser_id().'');
    }
    /**
     * Delete user
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function deleteuser(entity $post)
    {
        $this->bdd->query('DELETE FROM user WHERE id='.$post->getid().'');
    }
    /**
     * Update password
     * 
     * @param string $password it's new password
     * @param string $email    it's email
     * 
     * @return data
     */
    public function resetpassword($password,$email)
    {
        $sql = 'UPDATE user SET mdp=:mdp WHERE email=:email';
        $this->bdd->prepare($sql)->execute(array('mdp'=>$password->getmdp(),'email'=>$email));
    }
    /**
     * Get one user
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function getuser(entity $post)
    {
        return $this->bdd->query('SELECT * FROM user WHERE id='.$post->getid().''); 
    }
    /**
     * Update user
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function updateuser(entity $post)
    {
        $sql = 'UPDATE user SET nom=:nom, prenom=:prenom, email=:email  WHERE id=:id';
        $this->bdd->prepare($sql)->execute(array('nom'=>$post->getnom(),'prenom'=>$post->getprenom(),'email'=>$post->getemail(),'id'=>$post->getid()));
    }
    /**
     * Update password
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function updatepassword($post)
    {
        $sql = 'UPDATE user SET mdp=:mdp WHERE id=:id';
        $this->bdd->prepare($sql)->execute(array('mdp'=>$post->getmdp(),'id'=>$post->getid()));
    }
}