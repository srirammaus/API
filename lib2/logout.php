<?php
include_once '../config/db_conn.php'; 
class logout{
    private $username;
    private $token;
    private $db;
    function __construct($username,$token){
        $this->username=$username;
        $this->token=$token;
        
    }function delete_session(){
        $db2=new db_conn;
        $this->db=$db2->connect();
        $query_1="SELECT * FROM `session` WHERE `session`.`access_token`='$this->token' and `session`.`username`='$this->username';"; 
        $result_1=mysqli_query($this->db,$query_1);

        if(mysqli_num_rows($result_1) > 0){
            $query="DELETE FROM `session` WHERE `session`.`access_token`='$this->token' and `session`.`username`='$this->username';";
            $result=mysqli_query($this->db,$query);
        }else{
            throw new Exception("session Deleted");
        }
    }
}