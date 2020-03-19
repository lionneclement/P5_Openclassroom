<?php
/** 
 * The file is for retrieve post information from the database
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
use App\Entity\Commentaire;
use App\Model\Connectmodel;
/** 
 * The file is for retrieve post information from the database
 * 
 * PHP version 7.2.18
 * 
 * @category Model
 * @package  Model
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Postmodel extends Connectmodel
{
    /**
     * Get all posts
     * 
     * @return data
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
     * @return data
     */
    public function post(Article $post)
    {
        $sql = $this->bdd->prepare('SELECT * FROM article WHERE id=?');
        $sql->execute([$post->getid()]);
        return $sql->fetch(\PDO::FETCH_OBJ);
    }
    /**
     * Add post
     * 
     * @param array $post it's user data
     * 
     * @return data
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
     * @return data
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
     * @return data
     */
    public function remove(Article $post)
    {
        $sql = 'DELETE FROM commentaire WHERE article_id=?';
        $this->bdd->prepare($sql)->execute([$post->getid()]);
        $sql1 = 'DELETE FROM article WHERE id=?';
        $this->bdd->prepare($sql1)->execute([$post->getid()]);
    }
    /**
     * Get all comment
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function allComment(Article $post)
    {
        $sql='SELECT * FROM commentaire WHERE article_id=? AND statut=1';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getid()]);
        return $dbb->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Find one user
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function findUser($post)
    {
        $sql = $this->bdd->prepare('SELECT * FROM user WHERE id=?');
        $sql->execute([$post]);
        return $sql->fetch(\PDO::FETCH_OBJ);
    }
    /**
     * Add comment
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function addComment(Commentaire $post)
    {
        $sql = 'INSERT INTO commentaire (id,message,statut,date,user_id,article_id) 
    VALUES (NULL,?,0,CURRENT_TIMESTAMP,?,?)';
        $dbb =$this->bdd->prepare($sql);
        $dbb->execute([$post->getmessage(),$post->getuserId(),$post->getarticleId()]);
    }
    /**
     * Find all user
     * 
     * @return data
     */
    public function findAllUser()
    {
        $sql = $this->bdd->query('SELECT * FROM user');
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
}
