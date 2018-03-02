<?php
    //require_once("db_connect.php");
    

    /* This will connect us to our database... */
    //define("DBSV", "localhost");
    define("DBSV", "127.0.0.1");
    define("DBNAME", "gschedule");
    define("DBUSER", "nao");
    //define("DBPASS", "naow2696");
    define("DBPASS", "naow4583");

    $conn = mysql_connect(DBSV, DBUSER, DBPASS) or 
        die("Could not connect: " . mysql_error());
    mysqli_set_charset($conn, "utf8");
    mysql_select_db(DBNAME, $conn);


// The ext grid script will send  a task field which will specify what it wants to do
$task = '';
if ( isset($_POST['task'])){
    $task = $_POST['task'];
}
switch($task){
    case "LISTING":
        getList();
        break;
    case "UPDATEPRES":
        updateAccount();
        break;
    case "CREATEPRES":
        createAccount();
        break;
    case "DELETEPRES":
        deleteAccount();
        break;
    case "SEARCH":
        searchAccount();
        break;
    default:
        echo "{failure:true}";
        break;
}

function updateAccount() {
    $userid = $_POST['userid'];
    $passwd = addslashes($_POST['passwd']);
    $jpname = addslashes($_POST['jpname']);
    $email = $_POST['email'];
    $notify = $_POST['notify'];
    $admin = $_POST['admin'];

 // Now update the accoounttb;
    $query = 
        "UPDATE accounttb SET 
            userid = '$userid', 
            passwd = '$passwd', 
            jpname = '$jpname', 
            email = '$email', 
            notify = '$notify', 
            admin = '$admin' 
        WHERE userid='$userid'";
    $result = mysql_query($query);
    echo '1';
}

function createAccount(){
    $userid = addslashes($_POST['userid']);
    $passwd = addslashes($_POST['passwd']);
    $jpname = $_POST['jpname'];
    $email  = $_POST['email'];
    $notify = $_POST['notify'];
    $admin  = $_POST['admin'];

    $query = 
        "INSERT INTO accounttb (
            `userid` ,
            `passwd` ,
            `jpname` ,
            `email` ,
            `notify` ,
            `admin` ) 
         VALUES ('$userid' , '$passwd', '$jpname', '$email', '$notify', '$admin')";
    $result = mysql_query($query);
    echo '1';
}

function deleteAccount() {
    $ids = $_POST['ids']; // Get our array back and translate it :
    if (version_compare(PHP_VERSION,"5.2","<")) {    
        require_once("./JSON.php"); 
        $json = new Services_JSON();
        $idpres = $json->decode(stripslashes($ids));
    } else {
        $idpres = json_decode(stripslashes($ids));
    }
   
    // You could do some checkups here and return '0' or other error consts.
    // Make a single query to delete all of the accounts at the same time :
    if(sizeof($idpres) < 1) {
        echo '0';
    } else if (sizeof($idpres) == 1) {
        $query = "DELETE FROM accounttb WHERE userid = '" ."$idpres[0]'";
        mysql_query($query);
    } else {
        $query = "DELETE FROM accounttb WHERE ";
        for($i = 0; $i < sizeof($idpres); $i++) {
            $query = $query . "userid = '" ."$idpres[$i]'";
            if($i < sizeof($idpres) - 1) {
                $query = $query . " OR ";
            } 
        }
        mysql_query($query);
    }
    //This helps me find out what the heck is going on in Firebug...
    //echo $query;  
    echo '1';
}

function getList() {
/*
    $query = "use gschedule";
    mysqli_query($conn, $query);
*/
    $query = "SELECT userid, passwd, jpname, email, notify, admin FROM accounttb";
    $result = mysql_query($query);
    $nbrows = mysql_num_rows($result);  

    // Here we check if we have a query parameter :
    if (isset($_POST['query'])) {
        $query .= 
            " WHERE (userid LIKE '%".addslashes($_POST['query'])."%' OR jpname LIKE '%".addslashes($_POST['query'])."%')";
    }

/* 三項演算子（'？：'）テスト */
    $start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
    $end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
    $limit = $query." ORDER by userid LIMIT ".$start.",".$end; 
    $result = mysql_query($limit);  

    if($nbrows > 0){
        while($rec = mysql_fetch_array($result)){
            $arr[] = $rec;
        }
        $jsonresult = JEncode($arr);
        echo '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
    } else {
        echo '({"total":"0", "results":""})';
    }
}

function searchAccount() {

    $userid = $_POST['userid'];
    $jpname = $_POST['jpname'];
    $email = $_POST['email'];
    $notify = $_POST['notify'];
    $admin  = $_POST['admin'];

    $query = "SELECT * FROM accounttb WHERE userid <> ''";

    if($userid != ''){
        $query .= " AND userid LIKE '%".$userid."%'";
    };
    if($jpname != ''){
        $query .= " AND jpname LIKE '%".$jpname."%'";
    };
    if($email != ''){
        $query .= " AND email LIKE '%".$email."%'";
    };
    if ($notify != ''){
        $query .= " AND notify = '".$notify."'";
    };
    if ($admin != ''){
        $query .= " AND admin = '".$admin."'";
    };
    
    $result = mysql_query($query);
    $nbrows = mysql_num_rows($result);  

    $start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
    $end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
    $limit = $query." LIMIT ".$start.",".$end;      
    $result = mysql_query($limit);    

    if($nbrows>0){
        while($rec = mysql_fetch_array($result)){
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
   // if (version_compare(PHP_VERSION,"5.2","<")) {    
   //     require_once("./JSON.php");   //if php<5.2 need JSON class
   //     $json = new Services_JSON();  //instantiate new json object
   //     $data=$json->encode($arr);    //encode the data in json format
   // } else {
        $data = json_encode($arr);    //encode the data in json format
   // }
    return $data;
}

// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
function codeDate ($date) {
    $tab = explode ("-", $date);
    $r = $tab[1]."/".$tab[2]."/".$tab[0];
    return $r;
}
?> 
