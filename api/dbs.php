<?php
    include_once './api/helpers/index.php';
    class DBsModal{
      
        // database connection and table name
        private $conn;
        private $table_name = "dbs";
      
        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        public function create($obj=array()) {
            $query = "INSERT INTO `".$this->table_name."` (`id`, `host`, `db`, `uname`, `pwd`, `table`, `sid`, `ref`, `pid`) ";
            $query .= "VALUES (NULL, '".$obj->host."', '".$obj->db."', '".$obj->uname."', '".$obj->pwd."', '".$obj->table."', '".$obj->sid."', '".$obj->ref."', '".$obj->pid."')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }

        public function get_source_db() {
            $query = "SELECT * FROM `".$this->table_name."`";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $num = $stmt->rowCount();
            $r_arr=array();
            if($num > 0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $rep = array(
                        "host" => $host,
                        "db" => $db,
                        "uname" => $uname,
                        "pwd" => $pwd,
                        "table" => $table,
                        "sid" => $sid,
                        "ref" => $ref,
                        "pid" => $pid,
                    );
                    array_push($r_arr, $rep);
                }
            }
            if(count($r_arr)>0) return $r_arr[0];
            else{
                return array(
                    "host" => '',
                    "db" => '',
                    "uname" => '',
                    "pwd" => '',
                    "table" => '',
                    "sid" => '',
                    "ref" => '',
                    "pid" => '',
                );
            }
        }

        public function delete_all() {
            $query = "DELETE FROM `".$this->table_name."` WHERE 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }
    }
?>