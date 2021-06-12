<?php
error_reporting(E_ERROR | E_PARSE);
include 'index_lib.php';
include 'REST.api.php';

require_once '../config/db_conn.php'; 

function main(){
    $REST=new REST;
    try{
        $index= new index_lib;
    }catch(Exception $e){
        $data = [
            "error" => $e->getMessage()
        ];
        $data = $REST->json($data);
        $REST->response($data, 406);
    }     
    $REST=new REST;
    
    if($REST->get_request_method() == "POST" and isset($_REQUEST['username']) and isset($_REQUEST['password'])){
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        //echo "$password";
        try {
            $auth = new Auth($username, $password);
            $data = [
                "message" => "Login success",
                "tokens" => $auth->getAuthTokens()
            ];
            $data = $REST->json($data);
            $REST->response($data, 200);
        } catch(Exception $e){
            $data = [
                "error" => $e->getMessage()
            ];
            $data = $REST->json($data);
            $REST->response($data, 406);
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