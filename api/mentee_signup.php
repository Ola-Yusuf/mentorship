<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'model/Mentee.php';
    include_once 'model/Mentor.php';

    $mentee = new Mentee();
    $mentee->selectDatabase();

    $mentor = new Mentor();
    $mentor->selectDatabase();
    

    $data = json_decode(file_get_contents("php://input"));
    $create_date = date('Y-m-d H:i:s');
    $mentee->mentee_name = $data->name;
    $mentee->mentee_email = $data->email;
    $mentee->mentee_password = $data->password;
    $mentee->mentee_created = $create_date;
    
    $createResponse = $mentee->createMentee();
    
    if($createResponse['status'] === true){
        $mentee->closeDbConnection();
        $storeData['created'] = $create_date;
        $storeData['name'] = $data->name;
        $storeData['email'] = $data->email;
        $storeData['mentee_id'] = $createResponse['mentee_id'];

        $mentor->mentee_id = $createResponse['mentee_id'];
        $mentors = $mentor->getMentorsOfMentee();
        $success['totalMentor'] = count($mentors);
        $success['mentors'] = $mentors;
        $mentor->closeDbConnection();

        $success['status'] = 201;
        $success['message'] = 'Mentee created successfully.';
        $success['category'] = 'mentee';
        $success['profile'] = $storeData;
        $success['token'] = true;
        echo json_encode($success); 
    } else{
        $mentee->closeDbConnection();
        $mentor->closeDbConnection();
        // http_response_code(422);
        $error['status'] =  422; //unable to process
        $error['error'] = 'Unable to create Mentee Or Mentee Already Exist.';
        // $error['message'] = $createResponse;
        echo json_encode($error); 
    }
?>