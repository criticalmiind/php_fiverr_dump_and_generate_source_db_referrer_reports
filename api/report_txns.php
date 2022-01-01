<?php
    class ReportsTrnx{
      
        // database connection and table name
        private $conn;
        private $table_name = "report_txns";
      
        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        public function create($obj=array()) {
            $query = "INSERT INTO `".$this->table_name."` (`txn_id`, `report_id`, `user_id`, `public_id`, `referrer`, `tier`) ";
            $query .= "VALUES (NULL, '".$obj->report_id."', '".$obj->user_id."', '".$obj->public_id."', '".$obj->referrer."', '".$obj->tier."')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }

        public function delete_by_report_id($report_id) {
            $query = "DELETE FROM `".$this->table_name."` WHERE `report_id`=".$report_id;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }

        public function delete_tier_by_report_id($report_id=0, $tier=0) {
            $query = "DELETE FROM `".$this->table_name."` WHERE `report_id`='".$report_id."' AND `tier`='".$tier."'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }

        public function get_report_by_id($id=0) {
            $query = "SELECT * FROM `".$this->table_name."` WHERE `report_id`=".$id;

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $r_arr=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $rep=array(
                    "txn_id" => $txn_id,
                    "report_id" => $report_id,
                    "user_id" => $user_id,
                    "public_id" => $public_id,
                    "referrer" => $referrer,
                    "tier" => $tier,
                );
                array_push($r_arr, $rep);
            }
            return $r_arr;
        }

        public function get_process_report_last_index($id=0) {
            $query = "SELECT * FROM `".$this->table_name."` WHERE `report_id`=".$id." ORDER BY tier DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            $r_arr=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $rep=array(
                    "txn_id" => $txn_id,
                    "report_id" => $report_id,
                    "user_id" => $user_id,
                    "public_id" => $public_id,
                    "referrer" => $referrer,
                    "tier" => $tier,
                );
                array_push($r_arr, $rep);
            }
            return count($r_arr) > 0 ? $r_arr[0] : null;
        }
    }
?>