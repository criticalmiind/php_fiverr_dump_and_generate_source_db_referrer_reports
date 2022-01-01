<?php
	include_once './conn/session.php';
	include_once './check_source_db.php';
    
    $TIMER = 2; // set delay in tree levels
    $temp_list = []; // temp list to display
    $no_of_tier = 0; // counter for no of tier
    $processing_state_tier = 0;

    // get pending ref reports by default status 0
    $pending_tasks = $ref_report->get_list_by_status();
    
    // get first task of ref report
    $pending_task = (object)array();
    if(count($pending_tasks) > 0){
        $pending_task = $pending_tasks[0];
    }else{
        
        // get pending ref reports by status 1 (process state)
        $pending_tasks = $ref_report->get_list_by_status(1);
        if(count($pending_tasks) > 0){
            $pending_task = $pending_tasks[0];
        }else die();
        
        // $is_already_in_process = $ref_report->is_report_in_process($pending_task['report_id']);
        $index_of_tier = $report_trnx->get_process_report_last_index($pending_task['report_id']);
        if($index_of_tier){
            $processing_state_tier = $index_of_tier['tier'];
            $report_trnx->delete_tier_by_report_id($pending_task['report_id'], $processing_state_tier);
            // print_r($index_of_tier);
        } else die();
    }


    // update task state from new (0) to process (1)
    $ref_report->update_status($pending_task['report_id'], 1);
    
    // get user by id from source database
    // passing user id from pending task
    // get first user from list
    $usr = $users->get_user_by_id($pending_task['user_id']);
    if(count($usr) > 0){
        $usr = $usr[0];
    }else{
        // update task state from process (1) to completed (2)
        $ref_report->update_status($pending_task['report_id'], 2);
        die();
    }

    if($processing_state_tier == '0'){
        // create first user as a trnx report parent user
        // passing tier zero (becoz tree parent node)
        echo "first query ==== ".$processing_state_tier."<br><br>";
        $obj = (object) array(
            "report_id" => $pending_task['report_id'],
            "user_id" => $usr['id'],
            "referrer" => $usr['referrer']??0,
            "public_id" => $usr['p_id']??"",
            "tier" => 0
        );
        $report_trnx->create($obj);
    }

    // get pending task refs
    // if no ref found in list, then die cron here
    $u = $users->get_users_by_referrer($pending_task['user_id']);
    if(count($u) < 1) die();

    function create_txns_report($list=[]) {
        // accessing global variables
        global $temp_list;
        global $users;
        global $no_of_tier;
        global $pending_task;
        global $TIMER;
        global $processing_state_tier;

        // check for no of tier of tree
        if($no_of_tier >= $pending_task['tier']){
            return $temp_list;
        }

        // increament no of tier by one
        $no_of_tier++;
        
        if($processing_state_tier == 0 || $no_of_tier >= $processing_state_tier){
            // add tranx reports in db if list available with no of tier
            add_tanx_report($list??[], $no_of_tier);
        }

        // users list of n no of tier childs
        // ( store tree n no of level childs)
        $new_u_list = [];
        for ($i=0; $i < count($list); $i++) {
            $u1 = $list[$i];
            
            // pushing data in temp_list to display later
            array_push($temp_list, $u1);

            // get child of current user
            $u2 = $users->get_users_by_referrer($u1['id']);
            
            // add childs in list
            $new_u_list = array_merge($new_u_list, $u2??[]);
        }
        
        // again call create_txns_report method if there new users list availbele
        if(count($new_u_list) > 0){
            sleep($TIMER);
            return create_txns_report($new_u_list??[]);
        } else return $temp_list;
    }

    // execute create_txns_report method 
    $temp_list2 = create_txns_report($u);

    // method to set tranx data in db
    function add_tanx_report($list=[], $tier=0){
        global $pending_task;
        global $report_trnx;

        for ($i=0; $i < count($list); $i++) {
            $txn_rec = $list[$i];
            $obj = (object) array(
                "report_id" => $pending_task['report_id'],
                "user_id" => $txn_rec['id'],
                "referrer" => $txn_rec['referrer'],
                "public_id" => $txn_rec['p_id']??"",
                "tier" => $tier
            );
            $report_trnx->create($obj);
        }
    }

    // update task state from process (1) to completed (2)
    $ref_report->update_status($pending_task['report_id'], 2);


    echo "Done";
    // echo "<pre>";

    // echo "No Of Tiers = " . $no_of_tier . " ======= ";

    // print_r($temp_list2);
    
    // echo "</pre>";