<?php
//include 'index_lib.php';
include 'REST.api.php';
require_once '../lib2/logout.php';
function main(){
    //$index= new index_lib;
    $REST=new REST;
    //$logout= new logout;
    if($REST->get_request_method() == "POST" and isset($_REQUEST['username']) and isset($_REQUEST['access_token'])){
        $username=$_REQUEST['username'];
        $access_token=$_REQUEST['access_token'];
       
        try {
            $logout= new logout($username,$access_token);
            $logout->delete_session();
            $data = [
                "message" => "Logout success",
                
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
