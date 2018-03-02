<?php
session_start();
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.30 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : tododel.php                                         |
   | DATA-WRITTEN   : 2002.07.30                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2018.02.28                                          |
   +======================================================================*/
    require_once("sschk.php");  //session check
    require_once("footer.php"); //footer(outer file.)
    require_once("db_connect.php");
    $header_title = "[ ToDo削除 ]";

    $tid = $_GET["tid"];

    $delflg = $sesadmin;
    $sql = "select todotb.*,accounttb.jpname from todotb left join accounttb";
    $sql .= " on todotb.tuserid = accounttb.userid where tid = $tid";
    $res = mysql_query($sql, $conn);
    $nbrows = mysql_num_rows($res);  
    
    //他のユーザーによりレコードが削除されていた場合
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
    $row = mysql_fetch_assoc($res);
    //自分が書込んだTodo内容の場合
    if ($sesLoginID == $row["tuserid"]) {
        $delflg = 1;
    }
    if ($delflg == 0) {
        print ("<FONT color='red' size='2'>削除できません</FONT><BR>");
        print ("<A href=todo.php><FONT size='2'>[ 戻る ]</FONT></A>");    
        exit;
    }
    $todo = $row["todo"];
    $tdate = $row["tdate"];
    $pdate = substr($row["tdate"],0,4) ."/" .substr($row["tdate"],5,2) ."/" .substr($row["tdate"],8,2);
    $jpname = $row["jpname"];
    mysql_free_result($res);
    mysql_close($conn);
?>
<HTML>
<HEAD>
<TITLE>【ToDo削除／ToDo一覧表】</TITLE>
<META http-equiv='Content-Type' content='text/html;charset=UTF-8'>
<link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />
</HEAD>
<BODY>
<?php require_once("header.php"); ?>
<div id="content">
<!-- <div id="header"> -->
<div id="menu-ad">
<pre style="color:#3399CC;">
 [ 広告エリア ]
</pre>
</div>

<div id="main3">
<?php
    print ("<FORM name ='tododel' action='tododelsub.php' method='post'> \n");
    print ("<TABLE border='1' cellspacing='1' cellpadding='2' bordercolorlight='#7E1EFF' bodercolordark='#2400A5'> \n");
    print ("<TR><TD class='c4'>&nbsp;内　容&nbsp;</TD> \n");
    print ("<TD class='c2'><input type='text' name='todo' value='$todo' size=80 readonly> \n");
    print ("</TD></TR> \n");
    print ("<TR><TD class='c4'>&nbsp;期　日&nbsp;</TD> \n");
    print ("<TD class='c2'><input type='text' name='pdate' value='$pdate' size=12 readonly> \n");
    print ("<TD><input type='hidden' name='tdate' value='$tdate'> \n");
    print ("</TD></TR> \n");
    print ("<TD class='c4'>&nbsp;登録者&nbsp;</TD>\n");
    print ("<TD class='c2'><input type='text' name='jpname' value='$jpname' size=20 readonly> \n");
    print ("<input type='hidden' name='tid' value='$tid'> \n");
    print ("</TD></TR> \n");
    print ("</TABLE> \n");
    print ("<FONT color='red' size='2'>このTodo内容を削除します&nbsp</FONT> \n");
    print ("<input type='submit' value='実行'><BR> \n");
    print ("<A href='todo.php'><img src='./resources/images/ico_back1_10.gif' height='15' width='60'></A> \n");
    print ("</FORM> \n");
?>
<BR><BR>
</div>
</div>
</BODY>
</HTML>
