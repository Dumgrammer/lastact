<?php

    require_once "./modules/get.php";
    require_once "./modules/post.php";

    $get = new GET();
    $post = new POST();

    if(isset($_REQUEST['request'])){
        $request = explode('/',$_REQUEST['request']);
    }else{
        echo "This is invalid url";
        http_response_code(404);
    }

    //echo json_encode($request) ;
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            switch ($request[0]) {
                case 'employee':
                    $data =  $get->get_employee();
                    
                    echo $data;
                    //echo "This is my get employee endpoint ";
                    break;
                case 'job':
                    $data =  $get->get_job();
                    
                    echo $data;
                    //echo "this is my get job endpoint";
                    break;
                default:
                    echo "Invalid Endpoint";
                    http_response_code(403);
                    break;
            }
            //echo "Tis is my GET Method";
            break;
        case 'POST':

            $body_raw = json_decode(file_get_contents("php://input"));

            switch ($request[0]) {
                case 'employee':

                    $data =  $post->post_employee();
                    
                    echo $data;
                    //echo "This is my post employee endpoint ";
                    break;
                case 'job':
                    echo $data =  json_encode($post->post_job($body_raw));
                    
                    //echo $data;
                    //echo "this is my post job endpoint";
                    break;
                default:
                    echo "Invalid Endpoint";
                    http_response_code(403);
                    break;
            }
            //echo "This is my POST Method";
            break;
        default:
        echo "This is an unknwon method";
        http_response_code(401);
        break;


    }
?>