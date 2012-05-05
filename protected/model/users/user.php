<?php

/**
 * @copyright (C) 2012 TheRexStudio
 * @author Robert Strutts
 */
class User extends Model {
    
    /**
     * Schnippet members
     *
     * @var string $dbTable
     * @var string $dbPrimaryKey
     */
    protected $dbTable = 'users';     // set table name to connect to for this model
    protected $dbPrimaryKey = 'id';

    /**
     * Schnippet constructor
     * 
     * Must pass table name and primary key to Model class
     *
     * @return void
     */     
    function __construct() {
        parent::__construct($this->dbTable, $this->dbPrimaryKey);
    }
	
    /**
     * validates the user
     * 
     * @return void 
     */
    public function validate_login(){
        if ($_SESSION[APP_SES.'id'] == 0) { 
            $username = $_REQUEST['email'];
            $password = md5(SALT.$_REQUEST['password']);

            $sql = "SELECT {$this->primaryKey},email, fname, lname, password, temp_pwd, user_type FROM {$this->table} WHERE `email` = ? LIMIT 1";
            $query = $this->db->prepare($sql);
            $query->execute(array($username));
            $result = $query->fetch();
            $compair_pwd = $result['password'];

            if ($password == $compair_pwd) {
                $_SESSION[APP_SES.'id'] = $result[$this->primaryKey];
                $_SESSION[APP_SES.'email'] = $result['email'];
                $_SESSION[APP_SES.'fname'] = $result['fname'];
                $_SESSION[APP_SES.'lname'] = $result['lname'];
                $_SESSION[APP_SES.'user_type'] = $result['user_type'];
                if ($result['user_type']=='0') {
                    return LOGIN_DISABLED;
                }
                if ($result['temp_pwd']=='1') {
                    return LOGIN_RESET;
                }   
                return LOGIN_SUCCESS;
            } else {
                return LOGIN_INVALID;
            }
        } else {
            return LOGIN_SUCCESS;
        }
    }
    
    public function still_authorized() {
        if (!isset($_SESSION[APP_SES.'id']) || $_SESSION[APP_SES.'id'] == 0) {
             $this->loadView(SLASH . 'users' . SLASH . 'signin');
             exit;
        }
        $sql = "SELECT password FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute(array($_SESSION[APP_SES.'id']));
        $result = $query->fetch();
        $password = md5(SALT.$_REQUEST['current']);
        $compair_pwd = $result['password'];

        if ($password == $compair_pwd) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * email_exists returns true if email address is in the system
     * @return boolean 
     */
    public function email_exists() {
        $username = $_REQUEST['email'];
        $sql = "SELECT {$this->primaryKey} FROM {$this->table} WHERE `email` = ? LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute(array($username));
        $result = $query->fetch();
        if ($result[$this->primaryKey] > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_email_id() {
        $username = $_REQUEST['email'];
        $sql = "SELECT {$this->primaryKey} FROM {$this->table} WHERE `email` = ? LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute(array($username));
        $result = $query->fetch();
        return $result[$this->primaryKey];
    }
    
    public function get_users() {
        $sql = "SELECT {$this->primaryKey}, email, fname, lname, password, temp_pwd, user_type FROM {$this->table}";
        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;    
    }
    
    public function get_user($id) {
        if ($id==0) return false;
        $sql = "SELECT {$this->primaryKey}, email, fname, lname, password, temp_pwd, user_type FROM {$this->table} WHERE `id` = ? LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute(array($id));
        $result = $query->fetch();
        return $result; 
    }
        
}
?>