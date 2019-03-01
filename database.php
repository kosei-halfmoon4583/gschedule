<?php
    /*==========================================================================+
     | PHP version 7.1.16                                                       |
     +--------------------------------------------------------------------------+
     | Copyright (C) 2019.2.13 N.watanuki.                                      |
     +--------------------------------------------------------------------------+
     | Script-ID      : database.php                                            |
     | DATA-WRITTEN   : 2019.2.13                                               |
     | AUTHER         : _.________                                              |
     | UPDATE-WRITTEN : ____.__.__                                              |
     +==========================================================================*/
    // The ext grid script will send a task field which will specify what it wants to do
    $task = '';
    if (isset($_POST["task"])){
        $task = $_POST["task"];
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
        require_once("db_connect.php");
        
        $userid = $_POST["userid"];
        $passwd = addslashes($_POST["passwd"]);
        $jpname = addslashes($_POST["jpname"]);
        $email = $_POST["email"];
        $notify = $_POST["notify"];
        $admin = $_POST["admin"];

        $query = 
            "UPDATE accounttb SET 
                userid = '$userid', 
                passwd = '$passwd', 
                jpname = '$jpname', 
                email = '$email', 
                notify = '$notify', 
                admin = '$admin' 
            WHERE userid='$userid'";
        $result = mysqli_query($conn, $query);
        echo '1';

        mysqli_free_result($result);
        mysqli_close($conn);
    }

    function createAccount(){
        require_once("db_connect.php");
        
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
        $result = mysqli_query($conn, $query);
        echo '1';

        mysqli_free_result($result);
        mysqli_close($conn);
    }

    function deleteAccount() {
        require_once("db_connect.php");
        
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
            mysqli_query($conn, $query);
        } else {
            $query = "DELETE FROM accounttb WHERE ";
            for($i = 0; $i < sizeof($idpres); $i++) {
                $query = $query . "userid = '" ."$idpres[$i]'";
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

    function getList() {
        require_once("db_connect.php");
         
        $query = "SELECT userid, passwd, jpname, email, notify, admin FROM accounttb";
        $result = mysqli_query($conn, $query);
        $nbrows = mysqli_num_rows($result);  
        // Here we check if we have a query parameter :
        if (isset($_POST["query"])) {
            $query .= 
                " WHERE (userid LIKE '%".addslashes($_POST['query'])."%' OR jpname LIKE '%".addslashes($_POST['query'])."%')";
        }

    /* 三項演算子（'？：'）テスト：2019/2/13(Wed.) N.watanuki PHP7にUpgradeする場合は、以下の三項演算子を修正する必要がある 
        $start = (integer) (isset($_POST["start"]) ? $_POST["start"] : $_GET["start"]);
        $end = (integer) (isset($_POST["limit"]) ? $_POST["limit"] : $_GET["limit"]);
    */
        if(isset($_POST["start"])) {
            $start = $_POST["start"];
        } else {
            $start = $_GET["start"];
        }
        if(isset($_POST["limit"])) {
            $end = $_POST["limit"];
        } else {
            $end = $_GET["limit"];
        }

        $limit = $query." ORDER by userid LIMIT ".$start.",".$end; 
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
        
        mysqli_free_result($result);
        mysqli_close($conn);

    }

    function searchAccount() {
        require_once("db_connect.php");

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
        
        $result = mysqli_query($conn, $query);
        $nbrows = mysqli_num_rows($result);  

    /* 三項演算子（'？：'）テスト：2019/2/13(Wed.) N.watanuki PHP7にUpgradeする場合は、以下の三項演算子を修正する必要がある 
        $start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
        $end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
    */
        if(isset($_POST["start"])) {
            $start = $_POST["start"];
        } else {
            $start = $_GET["start"];
        }
        if(isset($_POST["limit"])) {
            $end = $_POST["limit"];
        } else {
            $end = $_GET["limit"];
        }
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

        mysqli_free_result($result);
        mysqli_close($conn);

    }

    // Encodes a SQL array into a JSON formated string
    function JEncode($arr) {
        $data = json_encode($arr);    //encode the data in json format
        return $data;
    }
    /* ---------------------------------*
     * If version of PHP under 5.2 then *
     *  you should use this logic to    *
     *  encoding JSON format.           *
     * ---------------------------------*
    function JEncode($arr) {
        if (version_compare(PHP_VERSION,"5.2","<")) {    
            require_once("./JSON.php");   // if php<5.2 need JSON class
            $json = new Services_JSON();  // instantiate new json object
            $data=$json->encode($arr);    // encode the data in json format
        } else {
            $data = json_encode($arr);    // encode the data in json format
        }
        return $data;
    }
    */

    // Encodes a YYYY-MM-DD into a MM-DD-YYYY string
    function codeDate ($date) {
        $tab = explode ("-", $date);
        $r = $tab[1]."/".$tab[2]."/".$tab[0];
        return $r;
    }
?> 
