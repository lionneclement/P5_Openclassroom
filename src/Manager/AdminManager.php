<?php
/** 
 * The file is for retrieve admin information from the database
 * 
 * PHP version 7.2.18
 * 
 * @category Manager
 * @package  Manager
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\Manager;

use App\Manager\Connectmodel;
use App\Entity\User;
/**
 * Class for retrieve admin information from the database
 * 
 * @category Manager
 * @package  Manager
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
        $sql->execute([$post->getId()]);
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    /**
     * Update role
     * 
     * @param array $post it's user data
     * 
     * @return void
     */
    public function updateRole(User $post):void
    {
        $sql = 'UPDATE user SET roleId=? WHERE id=?';
        $this->bdd->prepare($sql)->execute([$post->getRoleId(),$post->getId()]);
    }
    /**
     * Delete user
     * 
     * @param array $post it's user data
     * 
     * @return void
     */
    public function deleteUser(User $post):void
    {
        $sql2 =$this->bdd->prepare('DELETE FROM user WHERE id=?');
        $sql2->execute([$post->getId()]);
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
        $sql->execute([$post->getId()]);
        return $sql->fetch(\PDO::FETCH_OBJ);
    }
    /**
     * Update user
     * 
     * @param array $post it's user data
     * 
     * @return void
     */
    public function updateUser(User $post):void
    {
        $sql = 'UPDATE user SET lastName=?, firstName=?, email=?  WHERE id=?';
        $dbb = $this->bdd->prepare($sql);
        $dbb->execute([$post->getLastName(),$post->getFirstName(),$post->getEmail(),$post->getId()]);
    }
}
