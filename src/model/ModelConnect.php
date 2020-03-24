<?php
/** 
 * The file allows to connect to the database
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
/**
 * Class allows to connect to the database
 * 
 * @category Model
 * @package  Model
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Connectmodel
{
    protected $bdd;
    /**
     * The construct allows to connect to the database
     */
    public function __construct()
    {
        try {
            $this->bdd = new \PDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'));
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
