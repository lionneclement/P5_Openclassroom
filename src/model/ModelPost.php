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
namespace App\model;

use App\entity\Article;
use App\entity\Commentaire;
use App\model\connectmodel;
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
class Postmodel extends connectmodel
{
    /**
     * Get all posts
     * 
     * @return data
     */
    public function posts()
    {
        return $this->bdd->query('SELECT * FROM article ORDER BY date DESC');
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
        return $this->bdd->query('SELECT * FROM article WHERE id='.$post->getid().'');
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
    VALUES (NULL,:titre,:chapo,:contenu, CURRENT_TIMESTAMP,:user_id)';
        $this->bdd->prepare($sql)->execute(['titre'=>$post->gettitre(),'chapo'=>$post->getchapo(),'contenu'=>$post->getcontenu(),'user_id'=>$post->getuserId()]);
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
        $sql = 'UPDATE article SET titre=:titre, chapo=:chapo, contenu=:contenu, date=CURRENT_TIMESTAMP, user_id=:user_id WHERE id=:id';
        $this->bdd->prepare($sql)->execute(['titre'=>$post->gettitre(),'chapo'=>$post->getchapo(),'contenu'=>$post->getcontenu(),'user_id'=>$post->getuserId(),'id'=>$post->getid()]);
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
        $this->bdd->query('DELETE FROM commentaire WHERE article_id='.$post->getid().'');
        $this->bdd->query('DELETE FROM article WHERE id='.$post->getid().'');
    }
    /**
     * Get all comment
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function allcomment(Article $post)
    {
        return $this->bdd->query('SELECT * FROM commentaire WHERE article_id='.$post->getid().' AND statut=1');
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
        return $this->bdd->query('SELECT * FROM user WHERE id='.$post.'');
    }
    /**
     * Add comment
     * 
     * @param array $post it's user data
     * 
     * @return data
     */
    public function addcomment(Commentaire $post)
    {
        $sql = 'INSERT INTO commentaire (id, message, statut, date, user_id, article_id) 
    VALUES (NULL,:message,0,CURRENT_TIMESTAMP,:user_id,:article_id)';
        $this->bdd->prepare($sql)->execute(['message'=>$post->getmessage(),'user_id'=>$post->getuserId(),'article_id'=>$post->getarticleId()]);
    }
    /**
     * Find all user
     * 
     * @return data
     */
    public function findAlluser()
    {
        return $this->bdd->query('SELECT * FROM user');
    }
}
