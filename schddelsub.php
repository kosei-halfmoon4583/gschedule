<?php
session_start();
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.28 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : schddelsub.php                                      |
   | DATA-WRITTEN   : 2002.07.28                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2011.04.07                                          |
   +======================================================================*/
    require_once("sschk.php"); 
    require_once("db_connect.php");

    $sid = $_POST["sid"];
    $year = $_POST["year"];
    $month = $_POST["month"];
    $day = $_POST["day"];
    /* ------------------------------------------------- *
     * DELETE or UPDATE 実行時に、他のユーザに登録内容を *
     * 書き換えられていないかチェックするための変数      *
     * ------------------------------------------------- */
    $sdate = $_POST["sdate"];
    $sstime = $_POST["sstime"];
    $setime = $_POST["setime"];
    $cont1 = $_POST["cont1"];
    $cont2 = $_POST["cont2"];
     
    $sql = "SELECT * FROM schdtb WHERE sid = $sid";
    $res = mysql_query($sql, $conn);
    $nrow = mysql_num_rows($res);  

    //他ユーザーによりレコードが削除されていた場合
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

    $row = mysql_fetch_assoc($res);
    $pdate = substr($row["sdate"],0,4) ."/" .substr($row["sdate"],5,2) ."/" .substr($row["sdate"],8,2);
    if ((trim($sdate) != trim($row["sdate"])) 
        or (trim($sstime) != trim($row["sstime"]))
        or (trim($setime) != trim($row["setime"]))
        or (trim($cont1) != trim($row["cont1"]))
        or (trim($cont2) != trim($row["cont2"]))) {
        print ("<FONT color = red>他のユーザーにより変更されました</FONT><BR>");
        print ("日付：" .$pdate ."<br>");
        print ("開始時間：" .substr($row["sstime"],0,2) .":" .substr($row["sstime"],2,2) ."<BR>");
        print ("終了時間：" .substr($row["setime"],0,2) .":" .substr($row["setime"],2,2) ."<BR>");
        print ("内容：" .$row["cont1"] ."<BR>");
        print ("詳細：" .$row["cont2"] ."<BR>");
        print ("<A href=schd.php?year=$year&month=$month&day=$day>[ 戻る ]</A>");   
        exit;
    }
    //対象レコード削除
    $sql = "delete from schdtb where sid = $sid";
    $res = mysql_query($sql, $conn);
    if(mysql_error($conn)) {
        print "レコード削除に失敗しました！";
        echo mysql_errno($conn) . ": " . mysql_error($conn) . "\n";
        session_destroy();
        exit;
    } else {
        //正常に削除完了（schd.phpへ戻る）
        mysql_free_result($res);
        mysql_close($conn);
        header("Location: schd.php?year=$year&month=$month&day=$day");
    }
?>
