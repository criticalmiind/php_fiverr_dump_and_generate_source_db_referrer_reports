<?php
    class Users{
      
        // database connection and table name
        private $conn;
        private $table_name = "users";
        private $id = "id";
        private $p_id = "uname";
        private $referrer = "referrer";
      
        // constructor with $db as database connection
        public function __construct($db, $table, $id, $p_id, $ref){
            $this->conn = $db;
			$this->table_name = $table;
            $this->id = $id;
            $this->p_id = $p_id;
            $this->referrer = $ref;
        }

        function check_table(){
            $query = "SELECT * FROM ".$this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            return $num;
        }

        function get_records(){
            $query = "SELECT * FROM ".$this->table_name;

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $user_arr=array();
            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    try {
                        $users_list=array(
                            "id" => $row[$this->id],
                            "p_id" => $row[$this->p_id],
                            "referrer" => $row[$this->referrer]
                        );
                        array_push($user_arr, $users_list);
                    } catch (\Throwable $th) { }
                }
                return $user_arr;
            }
            return array();
        }

        function get_user_by_id($id){
            if(!$id) return (object)array();

            $query = "SELECT * FROM " . $this->table_name . " WHERE `" . $this->id . "`=" . $id;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $user_arr=array();
            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    try {
                        $users_list=array(
                            "id" => $row[$this->id],
                            "p_id" => $row[$this->p_id],
                            "referrer" => $row[$this->referrer]
                        );
                        array_push($user_arr, $users_list);
                    } catch (\Throwable $th) { }
                }
                return $user_arr;
            }
            return array();
        }

        function get_users_by_referrer($referrer){
            if(!$referrer) return (object)array();

            $query = "SELECT * FROM " . $this->table_name . " WHERE `" . $this->referrer . "`=" . $referrer;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $user_arr=array();
            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    // extract($row);
                    try {
                        $users_list=array(
                            "id" => $row[$this->id],
                            "p_id" => $row[$this->p_id],
                            "referrer" => $row[$this->referrer]
                        );
                        array_push($user_arr, $users_list);
                    } catch (\Throwable $th) { }
                }
                return $user_arr;
            }
            return array();
        }
    }
?>