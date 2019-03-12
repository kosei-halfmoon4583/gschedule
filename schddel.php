<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : schddel.php                                         |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");  
    require_once("db_connect.php");
    require_once("footer.php"); //footer(outer file.)
    $header_title = "[ 予定削除！]";
    
    /* for debug 2018.02.12 */
    $sid = $_GET["sid"];
    $year = $_GET["year"];
    $month = $_GET["month"];
    $day = $_GET["day"];
     
    /*-------------------------------------------------------*
     * $sid,$year,$month,$dayがURLパラメータとして渡される。 *
     *-------------------------------------------------------*/
    //削除フラグ
    $delflg = $sesadmin;
    $sql = "SELECT schdtb.*,accounttb.jpname FROM schdtb left join accounttb";
    $sql .= " on schdtb.suserid = accounttb.userid WHERE sid = $sid";
    $res = mysqli_query($conn, $sql);
    $nrow = mysqli_num_rows($res);  

    //他のユーザーによりレコードが削除されていた場合
    if($nrow == 0) {
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
        /* for debug 2018.02.12 */
        print (" for debug sid : $sid \n <br>");
        print (" -------------------  \n <br>");
         
        print ("<A href=schd.php?year=$year&month=$month&day=$day>戻る</A>");
        print ("</div> \n");
        print ("</div> \n");
        print ("</BODY> \n");
        print ("</HTML> \n");
        exit;
    }
    
    $row = mysqli_fetch_assoc($res);
    
    //書き込んだユーザーか？
    if ($sesLoginID == $row["suserid"]) {
        $delflg = 1;
    }
    if ($delflg == 0) {
        print ("<font color = red>削除できません</font><br>");
        print ("<a href=schd.php?year=$year&month=$month&day=$day>戻る</a>");
        exit;
    }
    $sdate = $row["sdate"];
    $pdate = substr($row["sdate"],0,4) ."/" .substr($row["sdate"],5,2) ."/" .substr($row["sdate"],8,2);
    $sstime = $row["sstime"];
    $setime = $row["setime"];
    $cont1 = $row["cont1"];
    $cont2 = $row["cont2"];
    // 時分を時間と分に分割
    $sshour = substr($sstime,0,2);
    $ssmin = substr($sstime,2,2);
    $dstime = $sshour .":" . $ssmin;
    $detime = "";
    if (!empty($setime)) {
        $sehour = substr($setime,0,2);
        $semin = substr($setime,2,2);
        $detime = $sehour .":" . $semin;
    }
    $crename = $row["jpname"];
    
    mysqli_free_result($res);
    mysqli_close($conn);
?>
<HTML>
<HEAD>
<TITLE>【予定削除】</TITLE>
<META http-equiv="Content-Type" content="text/html;CHARSET=UTF-8">
<link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />
</HEAD>
<BODY>
<?php require_once("header.php"); ?>
<div id="content">
<!-- <DIV id="header"> -->
<div id="menu-ad">
<PRE style="color:#3399CC;">
 [ 広告エリア ]
</PRE>
</div>
<div id="main3">
<?php
    //{schd 削除フォーム}
    print ("<FORM name ='schddel' action='schddelsub.php' method='post'> \n");
    print ("<TABLE border='1' cellspacing='1' cellpadding='2' bordercolorlight='#7E1EFF' bodercolordark='#2400A5'> \n");
    print ("<TR><TD class='c4'>&nbsp;日　時&nbsp;</TD> \n");
    print ("<TD class='c2'><INPUT type='text' name='pdate' value='$pdate' size=12 readonly> \n");
    print ("<TD><INPUT type='hidden' name='sdate' value='$sdate'> \n");
    print ("</TD></TR> \n");
    print ("<TR><TD class='c4'>&nbsp;開始予定&nbsp;</TD> \n");
    print ("<TD class='c2'><INPUT type='text' name='dstime' value='$dstime' size=6 readonly> \n");
    print ("<INPUT type='hidden' name='sstime' value='$sstime'> \n");
    print ("</TD></TR> \n");
    print ("<TR><TD class='c4'>&nbsp;終了予定&nbsp;</TD> \n");
    print ("<TD class='c2'><INPUT type='text' name='detime' value='$detime' size=6 readonly> \n");
    print ("<INPUT type='hidden' name='setime' value='$setime'> \n");
    print ("</TD></TR> \n");
    print ("<TR><TD class='c4'>&nbsp;内　容&nbsp;</TD> \n");
    print ("<TD class='c2'><INPUT type='text' name='cont1' value='$cont1' size=30 readonly> \n");
    print ("</TD></TR> \n");
    print ("<TR><TD class='c4'>&nbsp;詳　細&nbsp;</TD> \n");
    print ("<TD class='c2'><INPUT type='text' name='cont2' value='$cont2' size=80 readonly> \n");
    print ("</TD></TR> \n");
    print ("<TR><TD class='c4'>&nbsp;登録者&nbsp;</TD> \n");
    print ("<TD class='c2'><INPUT type='text' name='crename' value='$crename' size=20 readonly> \n");
    print ("<INPUT type='hidden' name='sid' value='$sid'> \n");
    print ("<INPUT type='hidden' name='year' value='$year'> \n");
    print ("<INPUT type='hidden' name='month' value='$month'> \n");
    print ("<INPUT type='hidden' name='day' value='$day'> \n");
    print ("</TD></TR> \n");
    print ("</TABLE><BR> \n");
    print ("<FONT color=red>この予定を削除します&nbsp;</FONT>");
    print ("<INPUT type='submit' value='実行'> \n");
    print ("</FORM> \n");
    print("<A href='schd.php?year=$year&month=$month&day=$day'><img src='./resources/images/ico_back1_10.gif' height='15' width='60'></A> \n");
?>
</div>
</div>
</BODY>
</HTML>
