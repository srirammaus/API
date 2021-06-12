<?php
error_reporting(E_ERROR | E_PARSE);
require_once '../config/db_conn.php'; 
include_once 'REST.api.php';
include 'index_lib.php';
function main(){
    $REST=new REST;
    try{
        $index=new index_lib;
    }catch (Exception $e){
        $data = [
            "error" => $e->getMessage()
        ];
        $data = $REST->json($data);
        $REST->response($data, 403);
    }
    
   
    if($REST->get_request_method() == "POST" and $index->isAuthenticated() ){
        try{
            $data = [
                "username" => $index->get_user(),
                "name"=>$index->get_name(),
                "check"=>$index->get_check(),
            ];
            $data = $REST->json($data);
            $REST->response($data, 200);
        } catch(Exception $e){
            $data = [
                "error" => $e->getMessage()
            ];
            $data = $REST->json($data);
            $REST->response($data, 403);
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