<?php
 
 class db_conn{
    private $hostname="localhost";
    private $db_name="auth";
    private $username="root";
    private $password="";
    public $conn;
    /*
    public function connect(){
        $this->conn=null;
        try { 
            $this->conn = new PDO('mysql:host=' . $this->hostname . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
          }
    
          return $this->conn;
    }*/
    public function connect(){
      //$this->conn=null;
      if($this->conn !=null){
        return $this->conn;
        
      }else{
        $this->conn=mysqli_connect($this->hostname,$this->username,$this->password,$this->db_name);
        if(!$this->conn){
          die("Connection failed: ".mysqli_connect_error());
        }else{
          return $this->conn;
        }
      }

    }
    
 }