<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : todoupd.php                                         |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");    
    require_once("db_connect.php");

    $tid = $_GET["tid"];

    // todotbテーブル
    $sql = "select todotb.*,accounttb.jpname from todotb left join accounttb";
    $sql .= " on todotb.tuserid = accounttb.userid where tid = $tid";
    $res = mysqli_query($conn, $sql);
    $nbrows = mysqli_num_rows($res);  

    //他のユーザーにレコードが削除されていた場合
    if($nbrows == 0) {
        print ("<HTML> \n");
        print ("<HEAD> \n");
        print ("<META http-equiv='Content-Type' content='text/html;CHARSET=UTF-8'> \n");
        print ("<link rel='stylesheet' type='text/css' href='./resources/css/gs.css' /> \n");
        print ("<TITLE>ToDo更新エラー</TITLE> \n");
        print ("</HEAD> \n");
        print ("<BODY> \n");
        print ("<div id='content'> \n");
        $header_title = "[ ToDo更新 Error! ]";
        require_once("header.php");
        print ("<div id='menu'> \n");
        print ("<pre style='color:#FFFFFF;'>.</pre> \n");
        print ("</div> \n");
        print ("<div id='main3'> \n");    
        print ("<FONT color='red'>あなたが編集中に他のユーザーにより削除されました！</FONT><BR><BR>");
        print ("<a href=todo.php>戻る</a>");    
        print ("</div> \n");
        print ("</div> \n");
        print ("</BODY> \n");
        print ("</HTML> \n");
        exit;
    }
    $row = mysqli_fetch_assoc($res);
    $tid = $row["tid"];
    $tdate = $row["tdate"];

    $_SESSION["stodo"] = array();
    $_SESSION["stodo"][0] = substr($tdate,0,4);
    $_SESSION["stodo"][1] = substr($tdate,5,2); 
    $_SESSION["stodo"][2] = substr($tdate,8,2); 
    $_SESSION["stodo"][3] = $row["todo"];
    $_SESSION["stodo"][4] = $row["jpname"];

    // 読込値保存
    $_SESSION["oldtodo"] = array();
    $_SESSION["oldtodo"][0] = $row["tdate"];
    $_SESSION["oldtodo"][1] = $row["todo"];
    mysqli_free_result($res);

    $_SESSION["stid"] = $tid;
    header("Location: todoin.php");
    mysqli_close($conn);
?>
