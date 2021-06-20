<?php

class Student{

	private $conn;
	private $table_name = "students";

	public $id;
    public $last_name;
    public $first_name;
    public $group_id;
    public $api_user_id;
    
    public function __construct($db){
        $this->conn = $db;
    }

	public function read_paging($from_record_num, $records_per_page){

  	    $query = "SELECT
	    			s.last_name, s.first_name, g.name as group_name, u.login as username
	            FROM
	                " . $this->table_name . " s
	            LEFT JOIN student_group g ON g.id = s.group_id
	            LEFT JOIN api_users u ON u.id = s.api_user_id
	            ORDER BY u.login DESC
	            LIMIT ? , ? ";

        $stmt = $this->conn->prepare($query);

	    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
	    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
	    $stmt->execute();

	    return $stmt;
	}
	public function count(){
	    $query = "SELECT COUNT(*) as num_rows FROM " . $this->table_name . "";
	    $stmt = $this->conn->prepare( $query );
	    $stmt->execute();
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    return $row['num_rows'];
	}
}