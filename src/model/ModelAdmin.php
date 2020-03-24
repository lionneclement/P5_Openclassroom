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
     * @return object
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
     * @return null
     */
    public function updateRole(User $post)
    {
        $sql = 'UPDATE user SET role_id=? WHERE id=?';
        $this->bdd->prepare($sql)->execute([$post->getroleId(),$post->getid()]);
    }
    /**
     * Get all comment
     * 
     * @return object
     */
    public function allComment()
    {
        $sql = $this->bdd->query('SELECT * FROM commentaire');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Update comment
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function updateComment(Commentaire $post)
    {
        $sql = 'UPDATE commentaire SET statut=? WHERE id=?';
        $this->bdd->prepare($sql)->execute([$post->getstatut(),$post->getid()]);
    }
    /**
     * Get all comment invalid
     * 
     * @return object
     */
    public function invalideComment()
    {
        $sql = $this->bdd->query('SELECT * FROM commentaire WHERE statut=0');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Delete comment with id comment
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function deleteComment(Commentaire $post)
    {
        $sql = $this->bdd->prepare('DELETE FROM commentaire WHERE id=?');
        $sql->execute([$post->getid()]);
    }
    /**
     * Delete user
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function deleteUser(User $post)
    {
        $sql = 'DELETE commentaire.* FROM commentaire INNER JOIN article
        ON article.user_id=? AND commentaire.article_id=article.id';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getid()]);
        $sql0 = $this->bdd->prepare('DELETE FROM commentaire WHERE user_id=?');
        $sql0->execute([$post->getid()]);
        $sql1 =$this->bdd->prepare('DELETE FROM article WHERE user_id=?');
        $sql1->execute([$post->getid()]);
        $sql2 =$this->bdd->prepare('DELETE FROM user WHERE id=?');
        $sql2->execute([$post->getid()]);
    }
    /**
     * Get one user
     * 
     * @param array $post it's user data
     * 
     * @return object
     */
    public function getUser(User $post)
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
     * @return null
     */
    public function updateUser(User $post)
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
     * @return null
     */
    public function updatePassword(User $post)
    {
        $sql = 'UPDATE user SET mdp=? WHERE id=?';
        $this->bdd->prepare($sql)->execute([$post->getmdp(),$post->getid()]);
    }
}