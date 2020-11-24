<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'model/Mentor.php';

    $mentor = new Mentor();
    $mentor->selectDatabase();

    $mentor->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $mentor->getSingleMentor();
    $mentor->closeDbConnection();

    if($mentor->mentor_name != null){
        // create array
        $emp_arr = array(
            "id" =>  $mentor->id,
            "name" => $mentor->mentor_name,
            "email" => $mentor->mentor_email,
            // "password" => $mentor->mentor_password,
            "created" => $mentor->mentor_created
        );
      
        http_response_code(200);
        $success['mentor'] = $emp_arr;
        echo json_encode($success);
    }
      
    else{
        http_response_code(404);
        $error['error'] = "Mentor not found.";
        echo json_encode($error);
    }
?>