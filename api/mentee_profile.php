<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'model/Mentee.php';

    $mentee = new Mentee();
    $mentee->selectDatabase();

    $mentee->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $mentee->getSingleMentee();
    $mentee->closeDbConnection();

    if($mentee->mentee_name != null){
        // create array
        $emp_arr = array(
            "id" =>  $mentee->id,
            "name" => $mentee->mentee_name,
            "email" => $mentee->mentee_email,
            // "password" => $mentee->mentee_password,
            "created" => $mentee->mentee_created
        );
      
        http_response_code(200);
        $success['mentee'] = $emp_arr;
        echo json_encode($success);
    }
      
    else{
        http_response_code(404);
        $error['error'] = "Mentee not found.";
        echo json_encode($error);
    }
?>