<?php
/** 
 * The file is for managing connected users
 * 
 * PHP version 7.2.18
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
namespace App\controller;

use App\twig\twigenvi;
use App\model\adminmodel;
use App\model\postmodel;
use App\entity\user;
use App\entity\commentaire;
/**
 * Class for managing connected users
 * 
 * @category Controller
 * @package  Controller
 * @author   Clement <lionneclement@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Admincontroller extends twigenvi
{
    private $_modelpost;
    private $_usercookie;
    /**
     * Init model and cookie
     */
    public function __construct()
    {
        parent::__construct();
        $this->_modelpost = new adminmodel;
        if (isset($_COOKIE['id'])) {
            $this->_usercookie['id'] = $_COOKIE['id'];
            $this->_usercookie['role'] = $_COOKIE['role'];
        }
    }
    /**
     * Register a user
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function register($post)
    {
        if (!isset($this->_usercookie)) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/user/register.html.twig');
            } else {
                $entitypost=new user($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $con = $this->_modelpost->check($entitypost);
                    $donnes = $con->fetchAll();
                    if (empty($donnes)) {
                        $this->_modelpost->register($entitypost);
                        echo $this->twigenvi->render('/templates/user/register.html.twig', ['alert'=>'success']);
                    } else {
                        echo $this->twigenvi->render('/templates/user/register.html.twig', ['alert'=>'already']);
                    }
                } else {
                    echo $this->twigenvi->render('/templates/user/register.html.twig', ['checking'=>$checking]);
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Login a user
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function login($post)
    {
        if (!isset($this->_usercookie)) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/user/login.html.twig');
            } else {
                $entitypost=new user($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $con = $this->_modelpost->check($entitypost);
                    $donnes = $con->fetch(\PDO::FETCH_ASSOC);
                    if (password_verify($post['mdp'], $donnes['mdp'])) {
                        $this->confcookie($donnes);
                        return header("LOCATION:/");
                    } elseif (!empty($donnes)) {
                        echo $this->twigenvi->render('/templates/user/login.html.twig', ['alert'=>'mdp']);
                    } else {
                        echo $this->twigenvi->render('/templates/user/login.html.twig', ['alert'=>'email']);
                    }
                } else {
                    echo $this->twigenvi->render('/templates/user/login.html.twig', ['checking'=>$checking]);
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Logout a user
     * 
     * @return template
     */
    public function logout()
    {
        setcookie('id', $_COOKIE['id'], time() - 3600, '/');
        setcookie('role', $_COOKIE['role'], time() - 3600, '/');
        return header("LOCATION:/");
    }
    /**
     * Create cookie
     * 
     * @param array $user it's user id and user role
     * 
     * @return template
     */
    public function confcookie($user)
    {
        setcookie('id', $user['id'], time()+(60*60*24*30), '/');
        setcookie('role', $user['role_id'], time()+(60*60*24*30), '/');
    }
    /**
     * Role a user
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function roles($post)
    {
        if ($this->_usercookie['role'] == 3) {
            if (empty($post)) {
                $con = $this->_modelpost->roles(new user(array('id'=>$this->_usercookie['id'])));
                $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
                echo $this->twigenvi->render('/templates/user/user.html.twig', ['user'=>$donnes,'access'=>$this->_usercookie['role']]);
            } else {
                $this->_modelpost->updaterole(new user($post));
                return header("LOCATION:/admin/roles");
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Page admin
     * 
     * @return template
     */
    public function admin()
    {
        if ($this->_usercookie['role'] == 3) {
            echo $this->twigenvi->render('/templates/user/admin.html.twig', ['access'=>$this->_usercookie['role']]);
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Show all comments and update comment
     * 
     * @param array  $post it's user data
     * @param string $type The param is to know if the comment is to be created or modified
     * 
     * @return template
     */
    public function comment($post,$type)
    {
        if ($this->_usercookie['role'] == 3) {
            if (empty($post)) {
                $con = $this->_modelpost->$type();
                $donnes = $con->fetchAll(\PDO::FETCH_ASSOC);
                echo $this->twigenvi->render('/templates/user/comment.html.twig', ['return'=>$type,'comment'=>$donnes,'access'=>$this->_usercookie['role']]);
            } else {
                $this->_modelpost->updatecomment(new commentaire($post));
                return header("LOCATION:/admin/$type");
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Delete comment
     * 
     * @param integer $id  it's id comment
     * @param array   $url the paramis here to find out in which url was doing the deletion
     * 
     * @return template
     */
    public function deletecomment($id,$url)
    {
        if ($this->_usercookie['role'] == 3 && !empty($id)) {
            $this->_modelpost->deletecomment(new commentaire(array('id'=>$id)));
            return header("LOCATION:/admin/$url");
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Delete user
     * 
     * @param integer $id it's user data
     * 
     * @return template
     */
    public function deleteuser($id)
    {
        if ($this->_usercookie['role'] == 3 && !empty($id)) {
            $this->_modelpost->deleteuser(new user(array('id'=>$id)));
            return header("LOCATION:/admin/roles");
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Send an email to be sure the user has the email and create a cookie
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function resetpassword($post)
    {
        if (empty($post)) {
            echo $this->twigenvi->render('/templates/user/reset.html.twig');
        } else {
            $con = $this->_modelpost->check(new user(array('email'=>$post['email'])));
            $donnes = $con->fetch(\PDO::FETCH_ASSOC);
            if (empty($donnes)) {
                echo $this->twigenvi->render('/templates/user/reset.html.twig', ['alert'=>'false']);
            } else {
                $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                shuffle($seed);
                $rand = '';
                foreach (array_rand($seed, 10) as $k) { 
                    $rand .= $seed[$k];
                }
                $obj = password_hash($rand, PASSWORD_DEFAULT);
                setcookie('reset', $obj, time()+(60*60), '/');
                mail($post['email'], 'Changement de mot de passe', 'Voici le lien pour changer de mot de passe: http://localhost/resetlink/'.$donnes['id'].'/'.$rand);
                echo $this->twigenvi->render('/templates/user/reset.html.twig', ['alert'=>'true']);
            }
        }
    }
    /**
     * Check if the cookie and the url match, if it's good reset password and delete cookie
     * 
     * @param integer $id   it's user id
     * @param string  $url  it's the url
     * @param array   $post it's user data
     * 
     * @return template
     */
    public function resetlink($id,$url,$post)
    {
        if (isset($_COOKIE['reset']) && password_verify($url, $_COOKIE['reset'])) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/user/resetpassword.html.twig', ['url'=>$url,'id'=>$id,'access'=>$this->_usercookie['role']]);
            } else {
                $entitypost=new user(array('mdp'=>$post['newpassword'],'id'=>$id));
                $checking = $entitypost->isValid(array('mdp'=>$post['newpassword'],'id'=>$id));
                if (empty($checking)) {
                    $this->_modelpost->updatepassword($entitypost);
                    setcookie('reset', '', -1, '/');
                    return header("LOCATION:/login");
                } else {
                    echo $this->twigenvi->render('/templates/user/resetpassword.html.twig', ['alert'=>'false','url'=>$url,'id'=>$id,'access'=>$this->_usercookie['role']]);
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
    /**
     * Update user (name,email)
     * 
     * @param array $post it's user data
     * 
     * @return template
     */
    public function updateuser($post)
    {
        if (isset($this->_usercookie['id'])) {
            $con = $this->_modelpost->getuser(new user(array('id'=>$this->_usercookie['id'])));
            $donnes = $con->fetch(\PDO::FETCH_ASSOC);
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/user/updateuser.html.twig', ['user'=>$donnes,'access'=>$this->_usercookie['role']]);
            } else {
                $entitypost=new user($post);
                $checking = $entitypost->isValid($post);
                if (empty($checking)) {
                    $post['id']=$this->_usercookie['id'];
                    $this->_modelpost->updateuser(new user(($post)));
                    $con = $this->_modelpost->getuser(new user(array('id'=>$this->_usercookie['id'])));
                    $donnes = $con->fetch(\PDO::FETCH_ASSOC);
                    echo $this->twigenvi->render('/templates/user/updateuser.html.twig', ['alert'=>true,'user'=>$donnes,'access'=>$this->_usercookie['role']]);
                } else {
                    echo $this->twigenvi->render('/templates/user/updateuser.html.twig', ['checking'=>$checking,'user'=>$donnes,'access'=>$this->_usercookie['role']]);
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
     /**
      * Check if the cookie and the url match, if it's good reset password and delete cookie
      * 
      * @param array $post it's user data
      * 
      * @return template
      */
    public function updatepassword($post)
    {
        if (isset($this->_usercookie['id'])) {
            if (empty($post)) {
                echo $this->twigenvi->render('/templates/user/updatepassword.html.twig', ['access'=>$this->_usercookie['role']]);
            } else {
                $con = $this->_modelpost->getuser(new user(array('id'=>$this->_usercookie['id'])));
                $donnes = $con->fetch(\PDO::FETCH_ASSOC);
                if (password_verify($post['oldpassword'], $donnes['mdp'])) {
                    $entitypost=new user(array('mdp'=>$post['newpassword'],'id'=>$this->_usercookie['id']));
                    $checking = $entitypost->isValid(array('mdp'=>$post['newpassword'],'id'=>$this->_usercookie['id']));
                    if (empty($checking)) {
                        $this->_modelpost->updatepassword($entitypost);
                        echo $this->twigenvi->render('/templates/user/updatepassword.html.twig', ['alert'=>'true','access'=>$this->_usercookie['role']]);
                    } else {
                        echo $this->twigenvi->render('/templates/user/updatepassword.html.twig', ['checking'=>$checking,'access'=>$this->_usercookie['role']]);
                    }
                } else {
                    echo $this->twigenvi->render('/templates/user/updatepassword.html.twig', ['alert'=>'false','access'=>$this->_usercookie['role']]);
                }
            }
        } else {
            return header("LOCATION:/");
        }
    }
}