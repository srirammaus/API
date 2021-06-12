<?php
include_once '../config/db_conn.php'; 

class signup{
    private $username;
    private $password;
    private $email;
    private $name;
    private $check_user;
    private $db;
    
    public function __construct($username,$password,$email,$name,$check_user){
        $db2=new db_conn;
    
        $this->db = $db2->connect();
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->name=$name;
        //if($this->userExists()){
          //  throw new Exception("User already exists");
        //}
        $bytes = random_bytes(16);
        $this->token = $token = bin2hex($bytes); //to verify users over email.
        $password = $this->hashPassword();
        //$email="shriram@xx.com";
        //$username="shriram";
        //Homework - make a proper flow to throw username already exists
        $query = "INSERT INTO `auth`.`auth` (`name`,`username`, `password`, `email`, `active` ,`check_user`, `token`) VALUES ('$name','$username', '$password', '$email', 1,'$check_user', '$token');";
        if(!mysqli_query($this->db, $query)){
            throw new Exception("Unable to signup, user account might already exist.");
            
        } else {
            $this->id = mysqli_insert_id($this->db);
            //$this->sendVerificationMail();
            //$f = new Folder();
            session_start();
            $_SESSION['username'] = $this->username;
            //$f->createNew('Default Folder');
            
        }
    }
    public function getInsertID(){
        return $this->id;
    }
    
    public function userExists(){
        //TODO: Write the code to check if user exists.
        return false;
    }
    
    public function hashPassword($cost = 10){
        //echo $this->password;
        $options = [
            "cost" => $cost
        ];
        return password_hash($this->password, PASSWORD_BCRYPT, $options);
    }
}
//$man= new main();
?>