<?php
header('Content-Type: application/json');
$current_dir = getcwd();
define('__ROOT__', $current_dir);
require_once(__ROOT__ . '/config.php');
$con = $mysqli;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $json = file_get_contents('php://input');

    // Decode the JSON data
    $data = json_decode($json, true);

    // Check if the JSON decoding was successful
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        // Handle JSON decode error
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON data"]);
        exit();
    }

    // echo '<pre>'; print_r( $data ); echo '</pre>';exit;
    if(isset($data) && !empty($data)){
        $arr = [];
        foreach ($data as $key => $value) {
            $internship_start_date = date('Y-m-d',strtotime($value['internship_start']));
            $internship_end_date = !empty($value['internship_end']) ? date('Y-m-d',strtotime($value['internship_end'])) : '';
            $feedback_status = !empty($value['feedback_status']) ? $value['feedback_status'] : "pending";
            $arr[] = "('".$value['name']."','".$value['contact_no']."','".$value['email']."','".$value['address']."','".$value['college_or_university']."','".$value['course']."','".$internship_start_date."','".$internship_end_date."','".$value['feedback']."','".$feedback_status."')";
        }
    
        $inset_str = implode(',',$arr);
        $u = "INSERT INTO `internship`(`name`, `contact_number`, `email`, `address`, `college_or_university`, `course`, `internship_start_date`, `internship_end_date`, `feedback`, `feedback_status`) VALUES ".$inset_str;
    
        header('Content-Type: application/json');
        $q = mysqli_query($con, $u);
        echo ($q) ? "DONE" : "Data not insert please run again";
    }else{
        header('Content-Type: application/json');
        echo "Data not found";
    }
    // echo json_encode(["received_data" => $data]);

} else {
    http_response_code(405);
    echo json_encode(["error" => "Only POST method is allowed"]);
}

// generate_output(1, "Your new password has been generated successfully.");
// generate_output(0, "Something went wrong with your request. Please try again later.");
mysqli_close($con);
