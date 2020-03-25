<?php
/** 
 * The file is for CRUD comment in the database
 * 
 * PHP version 7.2.18
 * 
 * @category Manager
 * @package  ModManagerel
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\Manager;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Manager\Connectmodel;
/** 
 * The file is for CRUD comment in the database
 * 
 * PHP version 7.2.18
 * 
 * @category Manager
 * @package  Manager
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

class CommentManager extends Connectmodel
{
    /**
     * Find all article comment
     * 
     * @param array $post it's user data
     * 
     * @return object
     */
    public function findAllArticleComment(Article $post)
    {
        $sql='SELECT commentaire.*,user.nom FROM article 
        INNER JOIN commentaire ON article.id=commentaire.article_id 
        AND commentaire.article_id=? AND commentaire.statut=1
        INNER JOIN user ON user.id=commentaire.user_id';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getId()]);
        return $dbb->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Find all comment invalid
     * 
     * @return object
     */
    public function findAllInvalideComment()
    {
        $sql = $this->bdd->query('SELECT * FROM commentaire WHERE statut=0');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Find all comment
     * 
     * @return object
     */
    public function findAllComment()
    {
        $sql = $this->bdd->query('SELECT * FROM commentaire');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Add comment
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function addComment(Commentaire $post)
    {
        $sql = 'INSERT INTO commentaire (id,message,statut,date,user_id,article_id) 
    VALUES (NULL,?,0,CURRENT_TIMESTAMP,?,?)';
        $dbb =$this->bdd->prepare($sql);
        $dbb->execute([$post->getMessage(),$post->getUserId(),$post->getArticleId()]);
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
        $this->bdd->prepare($sql)->execute([$post->getStatut(),$post->getId()]);
    }
    /**
     * Remove comment
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function removeComment(Commentaire $post)
    {
        $sql = $this->bdd->prepare('DELETE FROM commentaire WHERE id=?');
        $sql->execute([$post->getId()]);
    }
}