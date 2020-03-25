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

use App\Entity\Post;
use App\Entity\Comment;
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
     * Find all post comment
     * 
     * @param array $post it's user data
     * 
     * @return object
     */
    public function findAllPostComment(Post $post)
    {
        $sql='SELECT comment.*,user.lastName FROM post 
        INNER JOIN comment ON post.id=comment.postId 
        AND comment.postId=? AND comment.status=1
        INNER JOIN user ON user.id=comment.userId';
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
        $sql = $this->bdd->query('SELECT * FROM comment WHERE status=0');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Find all comment
     * 
     * @return object
     */
    public function findAllComment()
    {
        $sql = $this->bdd->query('SELECT * FROM comment');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Add comment
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function addComment(Comment $post)
    {
        $sql = 'INSERT INTO comment (id,message,status,date,userId,postId) 
    VALUES (NULL,?,0,CURRENT_TIMESTAMP,?,?)';
        $dbb =$this->bdd->prepare($sql);
        $dbb->execute([$post->getMessage(),$post->getUserId(),$post->getPostId()]);
    }
    /**
     * Update comment
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function updateComment(Comment $post)
    {
        $sql = 'UPDATE comment SET status=? WHERE id=?';
        $this->bdd->prepare($sql)->execute([$post->getStatus(),$post->getId()]);
    }
    /**
     * Remove comment
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function removeComment(Comment $post)
    {
        $sql = $this->bdd->prepare('DELETE FROM comment WHERE id=?');
        $sql->execute([$post->getId()]);
    }
}
