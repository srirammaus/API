<?php
require_once '../lib2/Auth.class.php';

class index_lib {
    private $auth=null;
    public function __construct(){
        $headers = getallheaders();
        if(isset($headers['Authorization'])){
            $token = explode(' ', $headers['Authorization']);
            $this->auth = new Auth($token[0]);
        }
    }

    public function isAuthenticated(){
       
        
        if($this->auth == null){
            return false;
        }
        if($this->auth->getOAuth()->authenticate() and isset($_SESSION['username'])){
            return true;
        } else {
            return false;
        }
    }public function get_user(){
        return $this->auth->getUsername();
    }public function get_name(){
        return $this->auth->getname();
    }public function get_check(){
        return $this->auth->getcheck();
    }
    
}
?>