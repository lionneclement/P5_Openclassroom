<?php
/** 
 * The file is for update password for the database
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
 * Class is for update password for the database
 * 
 * @category Manager
 * @package  Manager
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class PasswordManager extends Connectmodel
{
    /**
     * Update password
     * 
     * @param array $post it's user data
     * 
     * @return void
     */
    public function updatePassword(User $post):void
    {
        $sql = 'UPDATE user SET password=? WHERE id=?';
        $this->bdd->prepare($sql)->execute([$post->getPassword(),$post->getId()]);
    }
}
