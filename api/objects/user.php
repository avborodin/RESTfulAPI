<?php
class User{
	private $conn;
	private $table_name = "api_users";

	public $id;
    public $login;
    public $password;
    
    public function __construct($db){
        $this->conn = $db;
    }

    public function auth(){

	    $query = 'SELECT
	                u.id, u.login, u.password
	            FROM
	                '. $this->table_name .' u
	             WHERE 
	             	u.login = ?
             	LIMIT
                	0,1';

	    $stmt = $this->conn->prepare($query);
	    $stmt->bindParam(1, $this->login);
    	$stmt->execute();
	    
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    	if($row['id']){
    		if (password_verify($this->password, $row["password"])) {
				return $row;
			}
    	}
	}
}