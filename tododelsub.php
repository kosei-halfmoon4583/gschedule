<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : tododelsub.php                                      |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");    
    require_once("db_connect.php");

    /* for debug 2018/02/26 */
    $tid = $_POST["tid"];
    $todo = $_POST["todo"];
    $pdate = $_POST["pdate"];
    $tdate = $_POST["tdate"];
    $jpname = $_POST["jpname"];

    $sql = "select * from todotb where tid = $tid";
    $res = mysqli_query($conn, $sql);
    $nbrows = mysqli_num_rows($res);  

    //他のユーザーによりレコードが削除されていた場合
    if($nbrows == 0) {
        print ("<HTML> \n");
        print ("<HEAD> \n");
        print ("<META http-equiv='Content-Type' content='text/html;CHARSET=UTF-8'> \n");
        print ("<link rel='stylesheet' type='text/css' href='./resources/css/gs.css' /> \n");
        print ("<TITLE>ToDo削除エラー</TITLE> \n");
        print ("</HEAD> \n");
        print ("<BODY> \n");
        print ("<div id='content'> \n");
        $header_title = "[ ToDo削除 Error! ]";
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
    $pdate = substr($row["tdate"],0,4) ."/" .substr($row["tdate"],5,2) ."/" .substr($row["tdate"],8,2);
    if ((trim($todo) != trim($row["todo"])) 
        or (trim($tdate) != trim($row["tdate"])))   {
        print ("<FONT color = red>他のユーザーにより変更されました</FONT><BR>");
        print ("Todo内容" .$row["todo"] ."<BR>");
        print ("期日：" .$pdate ."<BR>");
        print ("<A href=todo.php>[ 戻る ]</A>");    
        exit;
    }
    //Delete the target record.
    $sql = "delete from todotb where tid = $tid";
    $res = mysqli_query($conn, $sql);

    if(mysqli_error($conn)) {
        print "レコードの更新に失敗しました！";
        echo mysqli_errno($conn) . ": " . mysqli_error($conn) . "\n";
        session_destroy();
        exit;
    } else {
        //正常に更新完了（todo.phpへ戻る）
        mysqli_free_result($result);
        mysqli_close($conn);
        header("Location: todo.php");
    }
?>
