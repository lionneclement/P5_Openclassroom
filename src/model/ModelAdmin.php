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
use App\entity\Commentaire;
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
     * Get all user without us
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function roles(User $post)
    {
        return $this->bdd->query('SELECT * FROM user WHERE NOT id='.$post->getid().''); 
    }
    /**
     * Update role
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function updaterole(User $post)
    {
        $sql = 'UPDATE user SET role_id=:role_id WHERE id=:id';
        $this->bdd->prepare($sql)->execute(['role_id'=>$post->getroleId(),'id'=>$post->getid()]);
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
    public function updatecomment(Commentaire $post)
    {
        $sql = 'UPDATE commentaire SET statut=:statut WHERE id=:id';
        $this->bdd->prepare($sql)->execute(['statut'=>$post->getstatut(),'id'=>$post->getid()]);
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
    public function deletecomment(Commentaire $post)
    {
        $this->bdd->query('DELETE FROM commentaire WHERE id='.$post->getid().'');
    }
    /**
     * Delete user
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function deleteuser(User $post)
    {
        $this->bdd->query('DELETE FROM commentaire WHERE user_id='.$post->getid().'');
        $this->bdd->query('DELETE FROM article WHERE user_id='.$post->getid().'');
        $this->bdd->query('DELETE FROM user WHERE id='.$post->getid().'');
    }
    /**
     * Get one user
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function getuser(User $post)
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
    public function updateuser(User $post)
    {
        $sql = 'UPDATE user SET nom=:nom, prenom=:prenom, email=:email  WHERE id=:id';
        $this->bdd->prepare($sql)->execute(['nom'=>$post->getnom(),'prenom'=>$post->getprenom(),'email'=>$post->getemail(),'id'=>$post->getid()]);
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