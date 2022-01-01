<?php
	class DumpDatabase {
		private $host = "localhost";
		private $db_name = "fiverr_referers";
		private $username = "root";
		private $password = "";
		public $conn;
	
		// get the database connection
		public function getConnection(){
			$this->conn = null;
			try{
				$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
				$this->conn->exec("set names utf8");
			}catch(PDOException $exception){
				echo json_encode([ "data"=>array(), "message"=>"Connection error: ".$exception->getMessage(), "success"=>false ]);
			}
			return $this->conn;
		}
	}
	
	class SourceDatabase {
	    private $host = "";
	    private $db_name = "";
	    private $username = "";
	    private $password = "";
	    public $conn;
	  
		// constructor with $db as database connection
        public function __construct($h, $db, $un, $p){
			$this->host = $h;
			$this->db_name = $db;
			$this->username = $un;
			$this->password = $p;
        }

	    // get the database connection
	    public function getConnection(){
	        $this->conn = null;
	        try{
	            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
	            $this->conn->exec("set names utf8");
	        }catch(PDOException $exception){
				echo "Connection error: ".$exception->getMessage();
	        }
	        return $this->conn;
	    }

		public function check_table($table='')
		{
			$query = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . $this->db_name . "' AND TABLE_NAME = '" . $table . "'";
			$stmt = $this->conn->prepare($query);
            $stmt->execute();
			$num = $stmt->rowCount();
            $r_arr=array();
            if($num > 0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $rep = array( "TABLE_NAME" => $TABLE_NAME );
                    array_push($r_arr, $rep);
                }
            }
			return count($r_arr) > 0;
		}
	}
?>