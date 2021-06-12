<?php
//$username=$_REQUEST['username'];
//$password=$_REQUEST['password'];
//$email=$_REQUEST['email'];
error_reporting(E_ERROR | E_PARSE);
include '../lib2/signup.php';
include 'REST.api.php';

function main(){
    $REST=new REST;
    $get_req_method=$REST->get_request_method();
    //echo $REST->get_request_method();
    if($get_req_method=="POST" and isset($_REQUEST['username']) and isset($_REQUEST['password']) and isset($_REQUEST['email']) and isset($_REQUEST['name']) and isset($_REQUEST['check']) ){
        //$man= new signup($username,$password,$email);
        $username=$_REQUEST['username'];
        $password=$_REQUEST['password'];
        $email=$_REQUEST['email'];
        $name=$_REQUEST['name'];
        $check_user=$_REQUEST['check'];
        try{
            $s = new signup($username, $password, $email,$name,$check_user);
            $data = [
                "message" => "Signup success",
                "userid" => $s->getInsertID()
            ];
            $REST->response($REST->json($data), 200);
        } catch(Exception $e) {
            $data = [
                "error" => $e->getMessage()
            ];
            $REST->response($REST->json($data), 409);
        }
         
    } else {
        $data = [
            "error" => "Bad request"
        ];
        $data = $REST->json($data);
        $REST->response($data, 400);
    }
    
}
main();
/*
include_once '../lib2/signup.php';
$username = 'username';
$email = 'email';
$password = 'password';
$man= new signup($username,$password,$email);*/