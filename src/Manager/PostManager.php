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

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Manager\Connectmodel;
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
class Postmodel extends Connectmodel
{
    /**
     * Get all posts
     * 
     * @return object
     */
    public function posts()
    {
        $sql = $this->bdd->query('SELECT * FROM article ORDER BY date DESC');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Get one post
     * 
     * @param array $post it's user data
     * 
     * @return object
     */
    public function post(Article $post)
    {
        $sql = 'SELECT article.*, user.nom FROM article
        INNER JOIN user ON 
        article.user_id=user.id AND article.id=?';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getid()]);
        return $dbb->fetch(\PDO::FETCH_OBJ);
    }
    /**
     * Add post
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function add(Article $post)
    {
        $sql = 'INSERT INTO article (id, titre, chapo, contenu, date, user_id)
        VALUES (NULL,?,?,?, CURRENT_TIMESTAMP,?)';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->gettitre(),$post->getchapo(),$post->getcontenu(),$post->getuserId()]);
    }
    /**
     * Update post
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function update(Article $post)
    {
        $sql = 'UPDATE article SET titre=?,chapo=?,contenu=?,date=CURRENT_TIMESTAMP,user_id=? WHERE id=?';
        $dbb =$this->bdd->prepare($sql);
        $dbb->execute([$post->gettitre(),$post->getchapo(),$post->getcontenu(),$post->getuserId(),$post->getid()]);
    }
    /**
     * Remove post
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function remove(Article $post)
    {
        $sql = 'DELETE FROM commentaire WHERE article_id=?';
        $this->bdd->prepare($sql)->execute([$post->getid()]);
        $sql1 = 'DELETE FROM article WHERE id=?';
        $this->bdd->prepare($sql1)->execute([$post->getid()]);
    }
    /**
     * Find one user
     * 
     * @param array $post it's user data
     * 
     * @return null
     */
    public function findUser(Article $post)
    {
        $sql = $this->bdd->prepare('SELECT * FROM user WHERE id=?');
        $sql->execute([$post->getid()]);
        return $sql->fetch(\PDO::FETCH_OBJ);
    }
    /**
     * Find all user
     * 
     * @return object
     */
    public function findAllUser()
    {
        $sql = $this->bdd->query('SELECT * FROM user');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
}
