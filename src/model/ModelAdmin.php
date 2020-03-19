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
namespace App\Model;

use App\Entity\Article;
use App\Model\Connectmodel;
use App\Entity\User;
use App\Entity\Commentaire;
/**
 * Class for retrieve admin information from the database
 * 
 * @category Model
 * @package  Model
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Adminmodel extends Connectmodel
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
        $sql = $this->bdd->prepare('SELECT * FROM user WHERE NOT id=?');
        $sql->execute([$post->getid()]);
        return $sql->fetchAll(\PDO::FETCH_OBJ);
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
        $sql = 'UPDATE user SET role_id=? WHERE id=?';
        $this->bdd->prepare($sql)->execute([$post->getroleId(),$post->getid()]);
    }
    /**
     * Get all comment
     * 
     * @return data
     */
    public function allcomment()
    {
        $sql = $this->bdd->query('SELECT * FROM commentaire');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
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
        $sql = 'UPDATE commentaire SET statut=? WHERE id=?';
        $this->bdd->prepare($sql)->execute([$post->getstatut(),$post->getid()]);
    }
    /**
     * Get all comment invalid
     * 
     * @return data
     */
    public function invalidecomment()
    {
        $sql = $this->bdd->query('SELECT * FROM commentaire WHERE statut=0');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Delete comment with id comment
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function deletecomment(Commentaire $post)
    {
        $sql = $this->bdd->prepare('DELETE FROM commentaire WHERE id=?');
        $sql->execute([$post->getid()]);
    }
    /**
     * Delete user
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function deleteUser(User $post)
    {
        $sql = $this->bdd->prepare('DELETE FROM commentaire WHERE user_id=?');
        $sql->execute([$post->getid()]);
        $sql1 =$this->bdd->prepare('DELETE FROM article WHERE user_id=?');
        $sql1->execute([$post->getid()]);
        $sql2 =$this->bdd->prepare('DELETE FROM user WHERE id=?');
        $sql2->execute([$post->getid()]);
    }
    /**
     * Find all posts with id user
     * 
     * @param array $post get id user
     * 
     * @return data
     */
    public function findAllPosts(User $post)
    {
        $sql = $this->bdd->prepare('SELECT * FROM article WHERE user_id=?');
        $sql->execute([$post->getid()]);
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Delete comment with id article
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function deleteAllCommentWithArticleid(Article $post)
    {
        $sql = $this->bdd->prepare('DELETE FROM commentaire WHERE article_id=?');
        $sql->execute([$post->getid()]);
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
        $sql = $this->bdd->prepare('SELECT * FROM user WHERE id=?');
        $sql->execute([$post->getid()]);
        return $sql->fetch(\PDO::FETCH_OBJ);
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
        $sql = 'UPDATE user SET nom=?, prenom=?, email=?  WHERE id=?';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getnom(),$post->getprenom(),$post->getemail(),$post->getid()]);
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
        $sql = 'UPDATE user SET mdp=? WHERE id=?';
        $this->bdd->prepare($sql)->execute([$post->getmdp(),$post->getid()]);
    }
}