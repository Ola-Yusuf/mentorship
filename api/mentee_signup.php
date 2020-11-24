<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'model/Mentee.php';

    $mentee = new Mentee();
    $mentee->selectDatabase();

    $data = json_decode(file_get_contents("php://input"));

    $mentee->mentee_name = $data->name;
    $mentee->mentee_email = $data->email;
    $mentee->mentee_password = $data->password;
    $mentee->mentee_created = date('Y-m-d H:i:s');
    
    $createResponse = $mentee->createMentee();

    if($createResponse === true){
        $mentee->closeDbConnection();
        http_response_code(200);
        $success['message'] = 'Mentee created successfully.';
        echo json_encode($success); 
    } else{
        $mentee->closeDbConnection();
        http_response_code(422);
        $error['error'] = 'Unable to create Mentee could not be created.';
        $error['message'] = $createResponse;
        echo json_encode($error); 
    }
?>