<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : schdupd.php                                         |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php"); 
    require_once("db_connect.php");
    require_once("sesReg.php");

    /* for debug 2018.02.16 確認済み、キチンと値がセットされている。*/
    $sid = $_GET["sid"];
    $year = $_GET["year"];
    $month = $_GET["month"];
    $day = $_GET["day"];
    $flag = $_GET["flag"];

    // schdtbテーブル
    $sql = "SELECT schdtb.*,accounttb.jpname FROM schdtb left join accounttb";
    $sql .= " on schdtb.suserid = accounttb.userid WHERE sid = $sid";

    $res = mysqli_query($conn, $sql);
    $nrow = mysqli_num_rows($res);  

    //他ユーザーによりレコードが削除されていた場合のError画面表示
    if($nrow == 0){
        print ("<HTML> \n");
        print ("<HEAD> \n");
        print ("<META http-equiv='Content-Type' content='text/html;CHARSET=UTF-8'> \n");
        print ("<link rel='stylesheet' type='text/css' href='./resources/css/gs.css' /> \n");
        print ("<TITLE>予定削除エラー</TITLE> \n");
        print ("</HEAD> \n");
        print ("<BODY> \n");
        print ("<div id='content'> \n");
        $header_title = "[ 予定削除 Error! ]";
        require_once("header.php");
        print ("<div id='menu'> \n");
        print ("<pre style='color:#FFFFFF;'>.</pre> \n");
        print ("</div> \n");
        print ("<div id='main3'> \n");    
        print ("<FONT color='red'>あなたが編集中に他のユーザーにより削除されました！</FONT><BR><BR>");
        print ("<A href='schd.php?year=$year&month=$month&day=$day'>[ 戻る ]</A>");
        print ("</div> \n");
        print ("</div> \n");
        print ("</BODY> \n");
        print ("</HTML> \n");
        exit;
    }
    $row = mysqli_fetch_assoc($res);
    $sid = $row["sid"];
    $sdate = $row["sdate"];
    $sstime = $row["sstime"];
    $setime = $row["setime"];

    sesReg_sschd();
    $_SESSION["sschd"][0] = substr($sdate,0,4);     
    $_SESSION["sschd"][1] = substr($sdate,5,2);     
    $_SESSION["sschd"][2] = substr($sdate,8,2);     
    $_SESSION["sschd"][3] = substr($sstime,0,2);
    $_SESSION["sschd"][4] = substr($sstime,2,2);
    $_SESSION["sschd"][5] = substr($setime,0,2);
    $_SESSION["sschd"][6] = substr($setime,2,2);
    $_SESSION["sschd"][7] = $row["cont1"];
    $_SESSION["sschd"][8] = $row["cont2"];
    $_SESSION["sschd"][9] = $row["jpname"];
    // 読込値保存
    $_SESSION["oldschd"] = array();
    $_SESSION["oldschd"][0] = $sdate;
    $_SESSION["oldschd"][1] = substr($sstime,0,2);
    $_SESSION["oldschd"][2] = substr($sstime,2,2);
    $_SESSION["oldschd"][3] = substr($setime,0,2);
    $_SESSION["oldschd"][4] = substr($setime,2,2);
    $_SESSION["oldschd"][5] = $row["cont1"];
    $_SESSION["oldschd"][6] = $row["cont2"];

    mysqli_free_result($result);
    $_SESSION["ssid"] = $sid;
    mysqli_close($conn);
    // header("Location:schdin.php?year=$sschd[0]&month=$sschd[1]&day=$sschd[2]&flag=$flag");
    header("Location:schdin.php?year=$year&month=$month&day=$day&flag=$flag");
    exit();
?>
