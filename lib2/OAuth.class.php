<?php

require_once 'Auth.class.php';
require_once '../config/db_conn.php'; 
require_once 'User.class.php';

class OAuth {
    private $db;
    private $refresh_token = null;
    private $access_token = null;
    private $username;
    private $user;
    private $name;
    private $check;

    /**
     * Can construct without refresh token for new session
     * Can construct with refresh token for refresh session
     */
    public function __construct($token = NULL){
        $db2=new db_conn;
        $this->db = $db2->connect();
        if($token != NULL){
            if($this->startsWith($token, 'a.')){
                $this->access_token = $token;
            }
            else {
                $this->setUsername($token); //-- if Wrong token
            }
        }
    }
    
    public function setUsername($username){
        $this->username = $username;
        $this->user = new User($this->username);
        $this->name=$this->user->getname();
        $this->check=$this->user->getcheck();
    }
   
    public function getUsername(){
        return $this->username;
    }
    public function getname(){
        
        return $this->name;
    }
    public function getcheck(){
        return $this->check;
    }
    public function authenticate(){
        if($this->access_token != null){
            $query = "SELECT * FROM auth.session WHERE access_token = '$this->access_token';";
            $result = mysqli_query($this->db, $query);
            if($result){
                $data = mysqli_fetch_assoc($result);
                
                if(isset( $data['username']) and isset($data['name'])){
                    
                    //$created_at = strtotime($data['created_at']);
                    //$expires_at = $created_at + $data['valid_for'];
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $this->username = $_SESSION['username'] =$data['username'];
                    $this->name = $_SESSION['name'] =$data['name'];
                    
                    $this->check = $_SESSION['check'] =$data['check_user']; 
                    
                    $_SESSION['token'] = $this->access_token;
                    
                    return true;
                    
                } else {
                    throw new Exception("Invalid Token");
                    
                }
            } else {
                throw new Exception(mysqli_error($this->db));
            }
        }
    }
    
    public function newSession(){
        if($this->username == NULL){
            throw new Exception("Username not set for OAuth");
        }
        
        $this->access_token = 'a.'.Auth::generateRandomHash(32);
        /*
        if($reference_token == 'auth_grant'){
            $this->refresh_token = 'r.'.Auth::generateRandomHash(32);
        } else {
            $this->refresh_token = 'd.'.Auth::generateRandomHash(16);
        }*/
        $query = "INSERT INTO `auth`.`session` (`username`,`name`,`check_user`, `access_token`) 
                                        VALUES ('$this->username', '$this->name','$this->check','$this->access_token');";
        if(mysqli_query($this->db, $query)){
            return array(
                "access_token" => $this->access_token,
                "type" => 'api'
            );
        } else {
            throw new Exception(mysqli_error($this->db));
        }
    }
   
    private function startsWith ($string, $startString){
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
}