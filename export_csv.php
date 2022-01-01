<?php 
include_once './conn/session.php';
include_once './check_source_db.php';

if(isset($_GET['report_id'])){
    extract($_GET);
    $reports = $report_trnx->get_report_by_id($report_id);

    $delimiter = ","; 
    $filename = "members-data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('txn_id', 'report_id', 'user_id', 'public_id', 'referrer', 'tier');
    fputcsv($f, $fields, $delimiter); 
     

    if(count($reports) > 0){
        foreach ($reports as $row) {
            $lineData = array($row['txn_id'], $row['report_id'], $row['user_id'], $row['public_id'], $row['referrer'], $row['tier']); 
            fputcsv($f, $lineData, $delimiter); 
        }
    }

    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f);
}
?>