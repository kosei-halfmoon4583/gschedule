<?php
  /*======================================================================+
   | PHP version 5.6.30                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _._________                                 |
   +----------------------------------------------------------------------+
   | Script-ID      : kwddb.php                                           |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : ____.__.__                                          |
   +======================================================================*/
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
        require_once("db_connect.php");

        $query = "SELECT kid, kwd, kurl, kusr, kemail, kdate, kcont FROM kwordtb";
        $result = mysqli_query($conn, $query);
        $nbrows = mysqli_num_rows($result);  

    /* [ Quick Search.] Here we check if we have a query parameter : */
        if (isset($_POST['query'])) {
            $query .= 
                " WHERE (kid LIKE '%".addslashes($_POST['query'])."%' OR kwd LIKE '%".addslashes($_POST['query'])."%')";
        }

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

        $limit = $query." ORDER by kid LIMIT ".$start.",".$end; 
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

    function updateKword() {
        require_once("db_connect.php");
        
        $kid = $_POST['kid'];
        $kwd = $_POST['kwd'];
        $kurl = addslashes($_POST['kurl']);
        $kusr = addslashes($_POST['kusr']);
        $kemail = $_POST['kemail'];
        $kdate = $_POST['kdate'];
        $kcont = $_POST['kcont'];

        $query = 
            "UPDATE kwordtb SET 
                 kwd = '$kwd', 
                 kurl = '$kurl', 
                 kusr = '$kusr', 
                 kemail = '$kemail', 
                 kdate = '$kdate', 
                 kcont = '$kcont' 
            WHERE kid = $kid";
        $result = mysqli_query($conn, $query);
        echo '1';

        mysqli_free_result($result);
        mysqli_close($conn);

    }

    function createKword(){
        require_once("db_connect.php");
        
        $kwd = addslashes($_POST['kwd']);
        $kurl = addslashes($_POST['kurl']);
        $kusr = $_POST['kusr'];
        $kemail  = $_POST['kemail'];
        $kdate = $_POST['kdate'];
        $kcont  = $_POST['kcont'];

        $query = 
            "INSERT INTO kwordtb (
                kwd ,
                kurl ,
                kusr ,
                kemail ,
                kdate ,
                kcont ) 
             VALUES ('$kwd', '$kurl', '$kusr', '$kemail', '$kdate', '$kcont')";
        $result = mysqli_query($conn, $query);
        echo '1';

        mysqli_free_result($result);
        mysqli_close($conn);

    }

    function deleteKword() {
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
        // Make a single query to delete all of the keywords at the same time :
        if(sizeof($idpres) < 1) {
            echo '0';
        } else if (sizeof($idpres) == 1) {
            $query = "DELETE FROM kwordtb WHERE kid = '" ."$idpres[0]'";
            mysqli_query($conn, $query);
        } else {
            $query = "DELETE FROM kwordtb WHERE ";
            for($i = 0; $i < sizeof($idpres); $i++) {
                $query = $query . "kid = '" ."$idpres[$i]'";
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
        require_once("db_connect.php");

        $kid = $_POST['kid'];
        $kwd = $_POST['kwd'];
        $kurl = $_POST['kurl'];
        $kusr = $_POST['kusr'];
        $kemail = $_POST['kemail'];
        $kcont  = $_POST['kcont'];

        $query = "SELECT * FROM kwordtb WHERE kid <> ''";

        if($kid != ''){
            $query .= " AND kid LIKE '%".$kid."%'";
        };
        if($kwd != ''){
            $query .= " AND kwd LIKE '%".$kwd."%'";
        };
        if($kurl != '') {
            $query .= " AND kurl LIKE '%".$kurl."%'";
        };
        if($kusr != '') {
            $query .= " AND kusr LIKE '%".$kusr."%'";
        };
        if($kemail != ''){
            $query .= " AND kemail LIKE '%".$kemail."%'";
        };
        if ($kcont != ''){
            $query .= " AND kcont = '".$kcont."'";
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

        mysqli_free_result($result);
        mysqli_close($conn);

    }

    // Encodes a SQL array into a JSON formated string
    function JEncode($arr) {
        if (version_compare(PHP_VERSION,"5.2","<")) {    
            require_once("./JSON.php");   //if php<5.2 need JSON class
            $json = new Services_JSON();  //instantiate new json object
            $data=$json->encode($arr);    //encode the data in json format
        } else {
            $data = json_encode($arr);    //encode the data in json format
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
