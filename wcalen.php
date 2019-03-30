<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : wcalen.php                                          |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : N.watanuki                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");
    require_once("wschd.php"); 
    require_once("sesUreg.php"); 
    require_once("footer.php");
    $header_title = "[ 週間予定 ]";
?>
<script type="text/javascript">
    function nextweek() { 
        days = 7;
        url = "weekadd.php";
        url = url + "?days=" + days;
        location.href = url;
    }
    function thisweek() { 
        days = 0;
        url = "thisweek.php";
        url = url + "?days=" + days;
        location.href = url;
    }
    function lastweek() {
        days = -7;
        url = "weekadd.php";
        url = url + "?days=" + days;
        location.href = url;
    }
</script>

<HTML>
<HEAD>
    <meta http-equiv="Content-Type" content="text/html;CHARSET=UTF-8">
    <TITLE>【週間予定表】</TITLE>
    <link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />
</HEAD>
<BODY>

<?php require_once("header.php"); ?>

<div id="content">
<div id="menu-weather">

<pre style="color:#3399CC;">
  [ お天気は如何でしょ？]
</pre>

<script type="text/javascript" src="http://n-de.jp/bp/wn/suzunari.js#wn_pos=4410">
</script>
<noscript>
<a href="http://n-de.jp/" title="中デザイン株式会社">中デザイン株式会社</a>
</noscript>
</div>

<div id="main3">
<?php 
    $flag = "";

    if (!isset($_SESSION["sCurMonday"])) {
        $_SESSION["sCurMonday"] = get_thisWeek_monday();
    }

    /* 今週ボタン対応ロジック（今週に戻すためのWork）*/
    if (!isset($_SESSION["thisMonday"])) {
        $_SESSION["thisMonday"] = get_thisWeek_monday();
    }
 
    /* 今週ボタンが押下されたかどうか判断するためのFlag */
    if (!isset($_SESSION["flag"])) {
      // $_SESSION["flag"]; 
    } else {
        $flag = $_SESSION["flag"];
    }
    
    print("<FORM> \n");
    print("<a href='javascript:void(0)' onClick='lastweek()'>
        <img src='./resources/images/icon_back.png' height='15' width='15'>&nbsp;前　週</a> \n");
    print("<a href='javascript:void(0)' onClick='thisweek()'>
        <img src='./resources/images/icon_now.png' height='15' width='15'>&nbsp;今　週</a> \n");
    print("<a href='javascript:void(0)' onClick='nextweek()'>
        <img src='./resources/images/icon_next.png' height='15' width='15'>&nbsp;次　週</a> \n");
    print("<BR><BR> \n");

    if ($flag == 1) {
        $startDay = getdate($_SESSION["thisMonday"]);
        $wschd = new wschd($startDay["year"],$startDay["mon"],$startDay["mday"]);
        $wschd->disp_calen();
        $flag = 0;
        unset($_SESSION["flag"]);
        $_SESSION["sCurMonday"] = get_thisWeek_monday();
        print("</FORM> \n");
    } else {
        $startDay = getdate($_SESSION["sCurMonday"]);
        $wschd = new wschd($startDay["year"],$startDay["mon"],$startDay["mday"]);
        $wschd->disp_calen();
        print("</FORM> \n");
    }
    /*------------------------------------------------*
     * 今日を含む週の月曜日の日付をYYYYMMDD形式で返す *
     *------------------------------------------------*/
    function get_thisWeek_monday() {
        $today = getdate();  //今日の日付を取得
        $wday = $today["wday"];
        if ($wday == 0) {
            $diff_day = 6;
        } else {
            $diff_day = $wday - 1;
        }
        return (mktime(0,0,0,$today["mon"],$today["mday"] - $diff_day,$today["year"])); 
    }
    //[$year,$month,$day]がURLパラメータとして渡ってこない場合の処理
    if (!isset($year)) {
        $today = getdate();
        $year = $today["year"];
        $month = $today["mon"];
        $day = $today["mday"];
    }
    print ("<TABLE> \n");
    print ("<TR><TD> \n");
    print("<img src='./resources/images/mini_b.gif' border='0'><FONT size='-1' color='#3366FF'>：予定あり</FONT> \n");
    print("</TD></TR> \n");
    print("<TR><TD>&nbsp;</TD></TR> \n");
    print("<TR><TD> \n");
    print("<A href='mcalen.php?year=$year&month=$month'><img src='./resources/images/btn_home1_5.gif' height='15' width='40'></A> \n");
    print("</TD></TR> \n");
    print("<TABLE> \n");
?>
</div>
</div>
</BODY>
</HTML>
