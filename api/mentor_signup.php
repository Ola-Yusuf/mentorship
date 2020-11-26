<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'model/Mentor.php';

    $mentor = new Mentor();
    $mentor->selectDatabase();

    $data = json_decode(file_get_contents("php://input"));

    $mentor->mentor_name = $data->name;
    $mentor->mentor_email = $data->email;
    $mentor->mentor_password = $data->password;
    $mentor->mentor_created = date('Y-m-d H:i:s');

    $createMentorResponse = $mentor->createMentor();
    if( $createMentorResponse['status'] === true){
        $mentor->closeDbConnection();
        unset($createMentorResponse['status']);
        // http_response_code(201);
        $success['status'] = 201;
        $success['message'] = 'Mentor created successfully.';
        $success['category'] = 'mentor';
        $success['profile'] = $createMentorResponse;
        $success['token'] = true;
        echo json_encode($success);
    } else{
        $mentor->closeDbConnection();
        // http_response_code(422);
        $error['status'] =  422; //unable to process
        $error['error'] =  'Unable to create Mentor Or Mentor Already Exist.';
        // $error['message'] =  $createMentorResponse;
        echo json_encode($error); 
    }
?>