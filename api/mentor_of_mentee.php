<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once 'model/Mentor.php';

    $mentor = new Mentor();
    $mentor->selectDatabase();

    $mentor->mentee_id = isset($_GET['mentee_id']) ? $_GET['mentee_id'] : die();

    $mentors = $mentor->getMentorsOfMentee();
    
    $mentorsCount = count($mentors);

    if($mentorsCount > 0){
        
        $mentor->closeDbConnection();

        http_response_code(200);
        $success['totalMentor'] = $mentorsCount;
        $success['mentors'] = $mentors;
        echo json_encode($success);
    }

    else{
        $mentor->closeDbConnection();

        http_response_code(404);
        $success['totalMentor'] = $mentorsCount;
        $success['mentors'] = [];
        echo json_encode($success);
    }
?>