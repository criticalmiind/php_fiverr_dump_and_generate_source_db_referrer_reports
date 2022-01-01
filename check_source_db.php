<?php

// include database and object files
include_once './conn/session.php';
include_once './conn/config.php';
include_once './api/users.php';
include_once './api/dbs.php';
include_once './api/refreports.php';
include_once './api/report_txns.php';

try {
    $dump_database = new DumpDatabase();
    $dump_db = $dump_database->getConnection();
    $dbs = new DBsModal($dump_db);
    $ref_report = new RefReports($dump_db);
    $report_trnx = new ReportsTrnx($dump_db);
} catch (\Throwable $th) {
    echo "Dump DB Error 001";
    die();
}

if(isset($_POST['db_create'])){
    extract($_POST);
    try {
        $obj = (object) array(
            "host" => $host,
            "db" => $db,
            "uname" => $uname,
            "pwd" => $pwd,
            "table" => $table,
            "sid" => $sid,
            "ref" => $ref,
            "pid" => $pid,
        );

        $dbs->delete_all();
        $dbs->create($obj);
        $sdb = $dbs->get_source_db();

        $database = new SourceDatabase($sdb['host'], $sdb['db'], $sdb['uname'], $sdb['pwd']);
        $db = $database->getConnection();

        if($database->check_table($sdb['table'])){
            $users = new Users($db, $sdb['table'], $sdb['sid'], $sdb['pid'], $sdb['ref']);
        }else{
            print_r($sdb['table'] . " Table Not found in source DB!");
            die();
        }

        if($users->check_table() < 1){
            print_r("Table Error");
            die();
        }
        $_SESSION['db'] = $_POST;
    } catch (\Throwable $th) {
        print_r("Source DB Error 001" . $th);
        die();
    }
}


try {
    $sdb = $dbs->get_source_db();

    $database = new SourceDatabase($sdb['host'], $sdb['db'], $sdb['uname'], $sdb['pwd']);
    $db = $database->getConnection();
    $users = new Users($db, $sdb['table'], $sdb['sid'], $sdb['pid'], $sdb['ref']);

    if($users->check_table() < 1){
        print_r("Table Error");
        die();
    }
} catch (\Throwable $th) {
    print_r("Source DB Error 002");
    die();
}