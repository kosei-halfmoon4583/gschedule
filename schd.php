<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : schd.php                                            |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");    
    require_once("db_connect.php");
    require_once("sesUreg.php"); //sschd ssid unregister
    require_once("footer.php");  //footer(outer file.)
    $header_title = "[ 予定登録/一覧表 ]";

    $year = $_GET["year"];
    $month = $_GET["month"];
    $day = $_GET["day"];
?>
<HTML>
<HEAD>
<TITLE>スケジュール</TITLE>
<META http-equiv="Content-Type" content="text/html;CHARSET=UTF-8">
<link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />
</HEAD>
<script type="text/javascript">
//予定変更
function schd_upd(sid,year,month,day) {
    flag = 0;
    url = "schdupd.php";
    url = url + "?sid=" + sid;
    url = url + "&year=" + year;
    url = url + "&month=" + month;
    url = url + "&day=" + day;
    url = url + "&flag=" + flag;
    location.href = url;
}
//予定追加
function schd_add(year,month,day){
    flag = 0;
    url = "schdin.php";
    url = url + "?year=" + year;
    url = url + "&month=" + month;
    url = url + "&day=" + day;
    url = url + "&flag=" + flag;
    location.href = url;
}
/*=[予定削除]====================================================*
    削除は2段構えに変更する。一覧の表示後，内容が変更されている  *
    可能性があるのでschddel.phpで再表示する。                    *
 *===============================================================*/
function schd_del(sid,year,month,day){
    url = "schddel.php";
    url = url + "?sid=" + sid;
    url = url + "&year=" + year;
    url = url + "&month=" + month;
    url = url + "&day=" + day;
    location.href = url;
}
</SCRIPT>

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
    //$year,$month,$dayがURLパラメータとして渡ってこない場合の処理
    if (!isset($year)) {        
        $today = getdate();
        $year = $today["year"];
        $month = $today["mon"];
        $day = $today["mday"];
    }
    //schedtbテーブルから一日の予定を取得
    $cond =$year . "/" .$month . "/" .$day;
    //日付はクォートで区切る必要あり
    $sql = "SELECT schdtb.*,accounttb.jpname FROM schdtb left join accounttb";
    $sql .= " ON schdtb.suserid = accounttb.userid";
    $sql .= " WHERE sdate = '$cond' ORDER by sstime";
    $res = mysqli_query($conn, $sql);
    $nrow = mysqli_num_rows($res);  

    if(mysqli_error($conn)) {
        print "レコードが取得できません…";
        echo mysqli_errno($conn) . ": " . mysqli_error($conn) . "\n";
        session_destroy();
        exit;
    }

    print("<FORM><INPUT type='button' value='予定追加' onclick='schd_add($year,$month,$day)'><BR><BR> \n");
    print("<TABLE BORDER='1' CELLSPACING='1' CELLPADDING='2' BORDERCOLORLIGHT='#000080' BORDERCOLORDARK='#3366CC'> \n"); 
    print("<TR> \n");
    print("<TH colspan=5 background='./resources/images/windows-bg.gif'><FONT color='#FFFFFF'>$year 年 $month 月 $day 日 </FONT></TH> \n");
    print("</TR> \n");
    print("<TR> \n");
    print("<TD class='c4'>&nbsp;開始予定&nbsp;</TD><TD class='c4'>&nbsp;終了予定&nbsp;</TD>
           <TD class='c4'>&nbsp;内　容</TD><TD class='c4'>&nbsp;登録者</TD>
           <TD class='c4'>&nbsp;操　作</TD></TR> \n");
    while ($row = mysqli_fetch_assoc($res)) { 
        $sid = $row["sid"];
        $sdate = $row["sdate"];
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
        print("<TD class='c2'>$dstime</TD> \n");
        print("<TD class='c2'>$detime</TD> \n");
        print("<TD class='c2'>$cont1<BR>$cont2</TD> \n");
        print("<TD class='c2'>&nbsp;$crename&nbsp;</TD> \n");
        print("<TD class='c2'> \n");
        print("&nbsp;<a href='javascript:void(0)' onClick='schd_upd($sid,$year,$month,$day)'>
            <img src='./resources/images/mini_b.gif' height='16' width='16'><u>&nbsp;変更</u></a>&nbsp;");
        print("&nbsp;<a href='javascript:void(0)' onClick='schd_del($sid,$year,$month,$day)'>
            <img src='./resources/images/ico_x.gif' height='11' width='11'><u>&nbsp;削除</u></a>&nbsp;");
        print("</TD> \n");
        print("</TR> \n");
    }
    print("</TABLE></FORM> \n");
    print("<A href='mcalen.php?year=$year&month=$month'><img src='./resources/images/btn_home1_5.gif' height='15' width='40'></A> \n");

    mysqli_free_result($res);
    mysqli_close($conn);
?>
</div>
</div>
</BODY>
</HTML>
