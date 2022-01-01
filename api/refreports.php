<?php
    class RefReports{
      
        // database connection and table name
        private $conn;
        private $table_name = "refreports";
      
        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        public function create($obj=array()) {
            $query = "INSERT INTO `".$this->table_name."` (`report_id`, `user_id`, `mainUser`, `tier`, `status`) ";
            $query .= "VALUES (NULL, '".$obj->user_id."', '".$obj->uname."', '".$obj->tier."', '0')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }

        public function update_status($report_id, $status) {
            $query = "UPDATE `".$this->table_name."` SET `status`=".$status." WHERE `report_id`=".$report_id;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }

        public function delete($report_id) {
            $query = "DELETE FROM `".$this->table_name."` WHERE `report_id`=".$report_id;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }

        public function get_list_by_status($status=0) {
            $query = "SELECT * FROM `".$this->table_name."` WHERE `status`=".$status;

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $r_arr=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $rep=array(
                    "report_id" => $report_id,
                    "user_id" => $user_id,
                    "mainUser" => $mainUser,
                    "tier" => $tier,
                    "status" => $status,
                );
                array_push($r_arr, $rep);
            }
            return $r_arr;
        }

        public function get_list($offset=10) {
            $query = "SELECT * FROM `".$this->table_name."` LIMIT 0, ".$offset;

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $r_arr=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $rep=array(
                    "report_id" => $report_id,
                    "user_id" => $user_id,
                    "mainUser" => $mainUser,
                    "tier" => $tier,
                    "status" => $status,
                );
                array_push($r_arr, $rep);
            }
            return $r_arr;
        }

        public function get_list_by_user_id($id=0) {
            $query = "SELECT * FROM `".$this->table_name."` WHERE `user_id`=".$id;

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $r_arr=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $rep=array(
                    "report_id" => $report_id,
                    "user_id" => $user_id,
                    "mainUser" => $mainUser,
                    "tier" => $tier,
                    "status" => $status,
                );
                array_push($r_arr, $rep);
            }
            return $r_arr;
        }


        public function is_report_in_process($id=0) {
            $query = "SELECT * FROM `".$this->table_name."` WHERE `report_id`='" . $id . "' AND `status`='1'";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            return $num > 0;
        }
    }
?>