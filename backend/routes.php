<?php   

    // Include required modules
    require_once "./modules/get.php";
    require_once "./modules/post.php";
    require_once "./config/database.php";

    $conn = new Connection();
    $pdo = $conn->connect();
    

    // Initialize Get and Post objects
    $get = new Get($pdo);
    $post = new Post($pdo);

    // Check if 'request' parameter is set in the request
    if(isset($_REQUEST['request'])){
         // Split the request into an array based on '/'
        $request = explode('/', $_REQUEST['request']);
    }
    else{
         // If 'request' parameter is not set, return a 404 response
        echo "Not Found";
        http_response_code(404);
    }

    // Handle requests based on HTTP method
    switch($_SERVER['REQUEST_METHOD']){
        // Handle GET requests
        case 'GET':
            switch($request[0]){
                case 'employees':
                    // Return JSON-encoded data for getting employees
                    if(count($request)>1){
                        echo json_encode($get->get_employees($request[1]));
                    }
                    else{
                        echo json_encode($get->get_employees());
                    }
                    break;
                
                case 'jobs':
                    // Return JSON-encoded data for getting employees
                    if(count($request)>1){
                        echo json_encode($get->get_jobs($request[1]));
                    }
                    else{
                        echo json_encode($get->get_jobs());
                    }
                    break;
                
                default:
                    // Return a 403 response for unsupported requests
                    echo "Invalid End point please also check the dir and req method";
                    http_response_code(403);
                    break;
            }
            break;
        // Handle POST requests    
        case 'POST':
            // Retrieves JSON-decoded data from php://input using file_get_contents
            $data = json_decode(file_get_contents("php://input"));
            switch($request[0]){
                case 'addemployees':
                
                        echo json_encode($post->add_employees($data));

                    break;
                    case 'locations':
                        if (count($request)>1) {
                            echo json_encode($post->post_locations($request[1]));
                        }
                        else{
                            echo json_encode($post->post_locations());
                        }
                        break;
                case 'editemployees':
                    // Return JSON-encoded data for adding employees
                    echo json_encode($post->edit_employees($data,$request[1]));
                    break;
                
                case 'deleteemployees':
                    // Return JSON-encoded data for adding jobs
                    echo json_encode($post->delete_employees($data,$request[1]));
                    break;
                
                default:
                    // Return a 403 response for unsupported requests
                    echo "This is forbidden";
                    http_response_code(403);
                    break;
            }
            break;
        default:
            // Return a 404 response for unsupported HTTP methods
            echo "Method not available";
            http_response_code(404);
        break;
    }

?>