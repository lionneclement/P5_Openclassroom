<?php
/** 
 * The file is for CRUD session
 * 
 * PHP version 7.2.18
 * 
 * @category Tools
 * @package  Tools
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\Tools;

/**
 * Class for CRUD session
 * 
 * @category Tools
 * @package  Tools
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Session
{
    /**
     * Setter session
     *
     * @param string           $key   The key
     * @param array|string|int $value The value
     * 
     * @return void
     */
    public static function setSession(string $key, $value):void
    {
        $_SESSION[$key]=$value;
    }
    /**
     * Getter session
     *
     * @param string $key The key
     * 
     * @return string|null
     */
    public static function getSession(string $key)
    {
        if (!empty($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }
    /**
     * Delete session
     *
     * @param string $key The key
     * 
     * @return void
     */
    public static function deleteSession(string $key):void
    {
        unset($_SESSION[$key]);
    }
    /**
     * Delete session
     * 
     * @return void
     */
    public static function deleteAllSession():void
    {
        session_unset();
    }
}
