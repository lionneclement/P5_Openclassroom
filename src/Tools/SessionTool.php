<?php
/** 
 * The file is for CRUD session
 * 
 * PHP version 7.2.18
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\Tools;

/**
 * Class for CRUD session
 * 
 * @category Controller
 * @package  Controller
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
     * @return null
     */
    public static function setSession(string $key, $value)
    {
        $_SESSION[$key]=$value;
    }
    /**
     * Getter session
     *
     * @param string $key The key
     * 
     * @return null|array
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
     * @return null
     */
    public static function deleteSession(string $key)
    {
        unset($_SESSION[$key]);
    }
    /**
     * Delete session
     * 
     * @return null
     */
    public static function deleteAllSession()
    {
        session_unset();
    }
}
