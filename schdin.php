<?php
session_start();
  /*======================================================================+
   | PHP version 5.6.30                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25                                             |
   +----------------------------------------------------------------------+
   | Script-ID      : schdin.php                                          |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : ____.__.__                                          |
   +======================================================================*/
    require_once("sschk.php"); 
    require_once("sesReg.php");
    require_once("footer.php");
    sesReg_sRet();

   /* --------------------------- *
    *  URL パラメータを受け取る   *
    *  Update written 2018.02.09  *
    * --------------------------- */
    if(isset($_GET["year"])) {
        $year = $_GET["year"];
    }
    if(isset($_GET["month"])) {
        $month = $_GET["month"];
    }
    if(isset($_GET["day"])) {
        $day = $_GET["day"];
    }
    if(isset($_GET["flag"])) {
        $flag = $_GET["flag"];
    }

    /*---------------------------------------------------*
     * URLパラメータとしてyear,month,day,flagが渡される。*
     *---------------------------------------------------*/
    if (isset($year)) { 
        $_SESSION["sRet"][0] = $year;
        $_SESSION["sRet"][1] = $month;
        $_SESSION["sRet"][2] = $day;
        $_SESSION["sRet"][3] = $flag;
    }
    $header_title = "[ 予定追加/変更登録 ]";
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html;CHARSET=UTF-8">
<TITLE>予定登録</TITLE>
<link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />
</HEAD>
<script type="text/javascript">
function formCfschd() {
    if (document.schdadd.tyear.value == "") { 
        alert("年を入力して下さい");
        document.schdadd.tyear.focus();
        return(false);
    }
    if (document.schdadd.tmonth.value == "") {  
        alert("月を入力して下さい");
        document.schdadd.tmonth.focus();
        return(false);
    }
    if (document.schdadd.tday.value == "") {    
        alert("日を入力して下さい");
        document.schdadd.tday.focus();
        return(false);
    }
    if (document.schdadd.cont1.value == "") {   
        alert("内容を入力して下さい");
        document.schdadd.cont1.focus();
        return(false);
    }
    rtn = confirm("予定を登録します。\nよろしいですか？");
    if (rtn) {
        return(true);
    } 
    return(false);
}
</SCRIPT>
<BODY>
<?php require_once("header.php"); ?>
<div id="content">
<div id="menu-ad">
<pre style="color:#3399CC;">
 [ 広告エリア ]
</pre>
</div>
<div id="main3">
<?php
    //flogの機能はなんだろうか?
    //if ($flag == 0) { //セッション変数として入力内容が保存されているケース
    if (isset($_SESSION["sschd"])) {
        $tyear = $_SESSION["sschd"][0];
        $tmonth = $_SESSION["sschd"][1];
        $tday = $_SESSION["sschd"][2];
        $sshour = $_SESSION["sschd"][3];
        $ssmin = $_SESSION["sschd"][4];
        $sehour = $_SESSION["sschd"][5];
        $semin = $_SESSION["sschd"][6];
        $cont1 = $_SESSION["sschd"][7];
        $cont2 = $_SESSION["sschd"][8];
        $crename = $_SESSION["sschd"][9];
    } else {
        if (isset($year)) {
            $tyear = $year;
            $tmonth = sprintf("%02d",$month);
            $tday = sprintf("%02d",$day);
        }
        $cont1 = '';  //変数の初期化（このコードがないと、Undefined variable: cont1 Error が
        $cont2 = '';  //表示されてしまう）
        $nowtime = getdate();
        $sshour = sprintf("%02d",$nowtime["hours"]);
        $ssmin = sprintf("%02d",$nowtime["minutes"]);
        $sehour = sprintf("%02d",$nowtime["hours"]);
        $semin = sprintf("%02d",$nowtime["minutes"]);
        $crename = $sesjpname;
    }
/* -- スケジュール入力フォーム ------- */
    print("<FORM name ='schdadd' action='schdinsub.php' method='POST'> \n");
    print ("<TABLE border='1' cellspacing='1' cellpadding='2' bordercolorlight='#7E1EFF' bodercolordark='#2400A5'> \n");
/* [日付] */
    print("<TR> \n");
    print("<TD class='c4'>&nbsp;予定日時&nbsp;</TD>\n");
    print("<TD class='c2'><INPUT type='text' name='tyear' value='$tyear' size='4'> \n");
    print("年 \n");
    print("<INPUT type='text' name='tmonth' value='$tmonth' size='2'> \n");
    print("月 \n");
    print("<INPUT type='text' name='tday' value='$tday' size='2'> \n");
    print("日 \n");
    print("</TD></TR> \n");

/* [開始時間（時）] */
    print("<TR> \n");
    print("<TD class='c4'>&nbsp;開始予定&nbsp;</TD> \n");
    print("<TD class='c2'><SELECT name='starthour' size='1' width='10'> \n");

    $ss_hour = 0;
    for ($i=0; $i<24; $i++) {
        if($i == $sshour) {
            $hs_timeStrings = sprintf("%02d",$ss_hour);
            print("<OPTION value='$hs_timeStrings' selected>$ss_hour</OPTION> \n");
            $ss_hour++;
        } else {
            $hs_timeStrings = sprintf("%02d",$ss_hour);
            print("<OPTION value='$hs_timeStrings'>$ss_hour</OPTION> \n");
            $ss_hour++;
        }
    }
    print("</SELECT> \n");
    print("時 \n");

/* [開始時間（分）] */
    print("<SELECT name='startmin' size='1'> \n");

    /*
    $ss_min = 0;
    for ($i=0; $i<60; $i++) {
        if($i == $ssmin) {
            $ms_timeStrings = sprintf("%02d",$ss_min);
            print("<OPTION value='$ms_timeStrings' selected>$ms_timeStrings</OPTION> \n");
            $ss_min++;
        } else {
            $ms_timeStrings = sprintf("%02d",$ss_min);
            print("<OPTION value='$ms_timeStrings'>$ms_timeStrings</OPTION> \n");
            $ss_min++;
        }
    }
    */
    $ss_min = 0;
    for ($i=0; $i<6; $i++) {
        if($ss_min == $ssmin) {
            $ms_timeStrings = sprintf("%02d",$ss_min);
            print("<OPTION value='$ms_timeStrings' selected>$ms_timeStrings</OPTION> \n");
            $ss_min = $ss_min + 10;
        } else {
            $ms_timeStrings = sprintf("%02d",$ss_min);
            print("<OPTION value='$ms_timeStrings'>$ms_timeStrings</OPTION> \n");
            $ss_min = $ss_min + 10;
        }
    }
    print("</SELECT> \n");
    print("分 \n");
    print("</TD></TR> \n");

/* [終了時間（時）] */
    print("<TR> \n");
    print("<TD class='c4'>&nbsp;終了予定&nbsp;</TD> \n");
    print("<TD class='c2'><SELECT name='endhour' size='1' width='10'> \n");

    $se_hour = 0;
    for ($i=0; $i<24; $i++) {
        if($i == $sehour) {
            $he_timeStrings = sprintf("%02d",$se_hour);
            print("<OPTION value='$he_timeStrings' selected>$se_hour</OPTION> \n");
            $se_hour++;
        } else {
            $he_timeStrings = sprintf("%02d",$se_hour);
            print("<OPTION value='$he_timeStrings'>$se_hour</OPTION> \n");
            $se_hour++;
        }
    }
    print("</SELECT> \n");
    print("時 \n");

    print("<SELECT name='endmin' size='1'> \n");

/* [終了時間（分）] */
    /*
    $se_min = 0;
    for ($i=0; $i<60; $i++) {
        if($i == $semin) {
            $me_timeStrings = sprintf("%02d",$se_min);
            print("<OPTION value='$me_timeStrings' selected>$me_timeStrings</OPTION> \n");
            $se_min++;
        } else {
            $me_timeStrings = sprintf("%02d",$se_min);
            print("<OPTION value='$me_timeStrings'>$me_timeStrings</OPTION> \n");
            $se_min++;
        }
    }
    */
    $se_min = 0;
    for ($i=0; $i<6; $i++) {
        if($se_min == $semin) {
            $me_timeStrings = sprintf("%02d",$se_min);
            print("<OPTION value='$me_timeStrings' selected>$me_timeStrings</OPTION> \n");
            $se_min = $se_min + 10;
        } else {
            $me_timeStrings = sprintf("%02d",$se_min);
            print("<OPTION value='$me_timeStrings'>$me_timeStrings</OPTION> \n");
            $se_min = $se_min + 10;
        }
    }
    print("</SELECT> \n");
    print("分 \n");
    print("</TD></TR> \n");
    print("<TR> \n");
    print("<TD class='c4'>&nbsp;予定内容&nbsp;</TD>\n");
    print("<TD class='c2'><INPUT type='text' name='cont1' value='$cont1' size='30'> \n");
    print("</TD></TR> \n");
    print("<TR> \n");
    print("<TD class='c4'>&nbsp;予定詳細&nbsp;</TD> \n");
    print("<TD class='c2'><INPUT type='text' name='cont2' value='$cont2' size='60'>&nbsp; \n");
    print("</TD></TR> \n");
    print("<TR> \n");
    print("<TD class='c4'>&nbsp;登録者&nbsp;</TD>\n");
    print("<TD class='c2'><INPUT type='text' name='crename' value='$crename' readonly> \n");
    /*---------------------------------------------------------------------------------*
     * 週間カレンダーから呼び出された場合には削除を指示するチェックボックスを表示する  *
     *---------------------------------------------------------------------------------*/
    // if ((isset($_SESSION["ssid"]))&&($sRet[3] == 2)) {
    if ((isset($_SESSION["ssid"]))&&($flag == 2)) {
        print("<INPUT type='checkbox' name='delFlag' value='t'> \n");
        print("<FONT color=Red>この予定を削除する</FONT> \n");
    }
    print("</TD></TR> \n");
    print("</TABEL> \n");
    print("<TABLE> \n");
    print("<TR><TD><INPUT type='submit' value='登録' onClick='return formCfschd()'> \n");
    print("</TD></TR> \n");
    print("</TABEL> \n");
    print("</FORM> \n");
    print("<TABLE> \n");
    print("<TR><TD>&nbsp;</TD></TR> \n");
    //print("<TR><TD><A href='schd.php?year=$sRet[0]&month=$sRet[1]&day=$sRet[2]'>
    print("<TR><TD><A href='schd.php?year=$year&month=$month&day=$day'>
        <img src='./resources/images/ico_back1_10.gif' height='15' width='60'></A><BR></TD></TR> \n");
    print("</TABLE> \n");
?>
</div>
</div>
</BODY>
</HTML>
