<?php
/** 
 * The file is for retrieve post information from the database
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
use App\Manager\ConnectManager;
/** 
 * The file is for retrieve post information from the database
 * 
 * PHP version 7.2.18
 * 
 * @category Manager
 * @package  Manager
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class PostManager extends ConnectManager
{
    /**
     * Get all posts
     * 
     * @return object
     */
    public function findAllpost()
    {
        $sql = $this->bdd->query('SELECT * FROM post ORDER BY date DESC');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Get one post
     * 
     * @param array $post it's user data
     * 
     * @return object
     */
    public function findOnePost(Post $post)
    {
        $sql = 'SELECT post.*, user.lastName FROM post
        INNER JOIN user ON 
        post.userId=user.id AND post.id=?';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getId()]);
        return $dbb->fetch(\PDO::FETCH_OBJ);
    }
    /**
     * Add post
     * 
     * @param array $post it's user data
     * 
     * @return void
     */
    public function addPost(Post $post):void
    {
        $sql = 'INSERT INTO post (id, title, extract, content, date, userId)
        VALUES (NULL,?,?,?, CURRENT_TIMESTAMP,?)';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getTitle(),$post->getExtract(),$post->getContent(),$post->getUserId()]);
    }
    /**
     * Update post
     * 
     * @param array $post it's user data
     * 
     * @return void
     */
    public function updatePost(Post $post):void
    {
        $sql = 'UPDATE post SET title=?,extract=?,content=?,date=CURRENT_TIMESTAMP,userId=? WHERE id=?';
        $dbb =$this->bdd->prepare($sql);
        $dbb->execute([$post->getTitle(),$post->getExtract(),$post->getContent(),$post->getUserId(),$post->getId()]);
    }
    /**
     * Remove post
     * 
     * @param array $post it's user data
     * 
     * @return void
     */
    public function removePost(Post $post):void
    {
        $sql1 = 'DELETE FROM post WHERE id=?';
        $this->bdd->prepare($sql1)->execute([$post->getId()]);
    }
}
