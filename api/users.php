<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('includes/config.php');
include_once('objects/student.php');
include_once('libs/utilities.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if(!isset($_SESSION["user"])){
    	echo json_encode(array("error"=>true));
		exit();
  	}

  	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$from_record_num = ($records_per_page * $page) - $records_per_page;

	$students = new Student($db);
	$total_rows = $students->count();

	$stmt = $students->read_paging($from_record_num, $records_per_page);
	$num = $stmt->rowCount();
  	
  	if ($num > 0) {

  		$student_arr = array();
	    $student_arr["records"] = array();
	    $student_arr["paging"] = array();

	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	        extract($row);

	        $item = array(
	            "last_name" => $last_name,
	            "first_name" => $first_name,
	            "group_name" => $group_name,
	            "username" => $username
            );

	        array_push($student_arr["records"], $item);
	    }
  		$total_rows = $students->count();
  		
  		$utilities = new Utilities();
    	
    	$paging = $utilities->getPaging($page, $total_rows, $records_per_page);
    	$student_arr["paging"] = $paging;

  		http_response_code(200);
    	echo json_encode($student_arr);
  	}else {
	    http_response_code(404);
		echo json_encode(array("message" => "Users not found"), JSON_UNESCAPED_UNICODE);
	}
  exit();
}
?>