<?php
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : schddb.php                                          |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("db_connect.php");

// The ext grid script will send  a task field which will specify what it wants to do
$task = '';
if ( isset($_POST['task'])) {
    $task = $_POST['task']; 
}
switch($task){
    case "LISTING":
        getList();
        break;
    case "UPDATEPRES":
        updateKword();
        break;
    case "CREATEPRES":
        createKword();
        break;
    case "DELETEPRES":
        deleteKword();
        break;
    case "SEARCH":
        searchKword();
        break;
    default:
        echo "{failure:true}";
        break;
}
function getList() {

    $query = "SELECT schdid, schd, surl, susr, semail, sdate, sremark FROM schdtitletb";
    $result = mysqli_query($conn, $query);
    $nbrows = mysqli_num_rows($result);  

/* [ Quick Search.] Here we check if we have a query parameter : */
    if (isset($_POST['query'])) {
        $query .= 
            " WHERE (schdid LIKE '%".addslashes($_POST['query'])."%' OR schd LIKE '%".addslashes($_POST['query'])."%')";
    }

/* 三項演算子（'？：'）テスト */
    $start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
    $end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
    $limit = $query." ORDER by schdid LIMIT ".$start.",".$end; 
    $result = mysqli_query($conn, $limit);  

    if($nbrows > 0){
        while($rec = mysqli_fetch_array($result)){
            $arr[] = $rec;
        }
        $jsonresult = JEncode($arr);
        echo '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
    } else {
        echo '({"total":"0", "results":""})';
    }
}

function updateKword() {
    $schdid = $_POST['schdid'];
    $schd = $_POST['schd'];
    $surl = addslashes($_POST['surl']);
    $susr = addslashes($_POST['susr']);
    $semail = $_POST['semail'];
    $sdate = $_POST['sdate'];
    $sremark = $_POST['sremark'];

    $query = 
        "UPDATE schdtitletb SET 
             schd =   '$schd', 
             surl =   '$surl', 
             susr =   '$susr', 
             semail = '$semail', 
             sdate =  '$sdate', 
             sremark = '$sremark' 
        WHERE schdid = $schdid";
    $result = mysqli_query($conn, $query);
    echo '1';
}

function createKword(){
    $schd = addslashes($_POST['schd']);
    $surl = addslashes($_POST['surl']);
    $susr = $_POST['susr'];
    $semail  = $_POST['semail'];
    $sdate = $_POST['sdate'];
    $sremark  = $_POST['sremark'];

    $query = 
        "INSERT INTO schdtitletb (
            schd ,
            surl ,
            susr ,
            semail ,
            sdate ,
            sremark ) 
         VALUES ('$schd', '$surl', '$susr', '$semail', '$sdate', '$sremark')";
    $result = mysqli_query($conn, $query);
    echo '1';
}

function deleteKword() {
    $ids = $_POST['ids']; // Get our array back and translate it :
    if (version_compare(PHP_VERSION,"5.2","<")) {    
        require_once("./JSON.php"); 
        $json = new Services_JSON();
        $idpres = $json->decode(stripslashes($ids));
    } else {
        $idpres = json_decode(stripslashes($ids));
    }
   
    // You could do some checkups here and return '0' or other error consts.
    // Make a single query to delete all of the keywords at the same time :
    if(sizeof($idpres) < 1) {
        echo '0';
    } else if (sizeof($idpres) == 1) {
        $query = "DELETE FROM schdtitletb WHERE schdid = '" ."$idpres[0]'";
        mysqli_query($conn, $query);
    } else {
        $query = "DELETE FROM schdtitletb WHERE ";
        for($i = 0; $i < sizeof($idpres); $i++) {
            $query = $query . "schdid = '" ."$idpres[$i]'";
            if($i < sizeof($idpres) - 1) {
                $query = $query . " OR ";
            } 
        }
        mysqli_query($conn, $query);
    }
    //This helps me find out what the heck is going on in Firebug...
    //echo $query;  
    echo '1';
}

function searchKword() {

    $schdid = $_POST['schdid'];
    $schd = $_POST['schd'];
    $surl = $_POST['surl'];
    $susr = $_POST['susr'];
    $semail = $_POST['semail'];
    $sremark  = $_POST['sremark'];

    $query = "SELECT * FROM schdtitletb WHERE schdid <> ''";

    if($schdid != ''){
        $query .= " AND schdid LIKE '%".$schdid."%'";
    };
    if($schd != ''){
        $query .= " AND schd LIKE '%".$schd."%'";
    };
    if($surl != '') {
        $query .= " AND surl LIKE '%".$surl."%'";
    };
    if($susr != '') {
        $query .= " AND susr LIKE '%".$susr."%'";
    };
    if($semail != ''){
        $query .= " AND semail LIKE '%".$semail."%'";
    };
    if ($sremark != ''){
        $query .= " AND sremark = '".$sremark."'";
    };
    
    $result = mysqli_query($conn, $query);
    $nbrows = mysqli_num_rows($result);  

    $start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
    $end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
    $limit = $query." LIMIT ".$start.",".$end;      
    $result = mysqli_query($conn, $limit);    

    if($nbrows>0){
        while($rec = mysqli_fetch_array($result)){
            // render the right date format
            $rec['tookoffice']=codeDate($rec['tookoffice']);
            $rec['leftoffice']=codeDate($rec['leftoffice']);      
            $arr[] = $rec;
        }
        $jsonresult = JEncode($arr);
        echo '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
    } else {
        echo '({"total":"0", "results":""})';
    }
}

// Encodes a SQL array into a JSON formated string
function JEncode($arr) {
    if (version_compare(PHP_VERSION,"5.2","<")) {    
        require_once("./JSON.php");    //if php<5.2 need JSON class
        $json = new Services_JSON();   //instantiate new json object
        $data=$json->encode($arr);     //encode the data in json format
    } else {
        $data = json_encode($arr);     //encode the data in json format
    }
    return $data;
}

// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
function codeDate ($date) {
    $tab = explode ("-", $date);
    $r = $tab[1]."/".$tab[2]."/".$tab[0];
    return $r;
}
?> 
