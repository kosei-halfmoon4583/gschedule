<?php
session_start();
  /*==========================================================================+
   | PHP version 5.3.8 -> version 5.6.30                                      |
   +--------------------------------------------------------------------------+
   | Copyright (C) 2002.07.16 N.watanuki                                      |
   +--------------------------------------------------------------------------+
   | Script-ID      : mcalen.php                                              |
   | DATA-WRITTEN   : 2007.12.13                                              |
   | AUTHER         : N.WATANUKI                                              |
   | UPDATE-WRITTEN : 2012.03.31  MacOSX(version 10.7)へ移植                  |
   | UPDATE-WRITTEN : 2014.06.02  表示変更                                    |
   | UPDATE-WRITTEN : 2018.03.08  Alter session variable.                     |
   +==========================================================================*/
    require_once("sschk.php");
    require_once("mschd.php");
    require_once("sesUreg.php"); /* Session Unregister */
    require_once("wekUreg.php"); /* Session Unregister (Return from wcalen.php.) */
    require_once("usrlist.php"); 
    require_once("footer.php");
    $header_title = "[ 月間予定 ]";
?>
<HTML lang="ja">
<HEAD>
<META http-equiv="Content-Type" content="text/html;CHARSET=UTF-8">
<TITLE>[ Schedule Management System ]</TITLE>
<link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />

<script type="text/javascript">
function fwdym(year,month) {  //Forward Year & Month
    if ( month < 12 ) {
        month++;
    } else {
        year++;
        month=1;
    }
    url = "mcalen.php";
    url = url + "?year=" + year;
    url = url + "&month=" + month;
    location.href = url;
}
function backym(year,month) {  //Backward Year & Month
    if ( month < 2 ) {
        year--;
        month=12;
    } else {
        month--;
    }
    url = "mcalen.php";
    url = url + "?year=" + year;
    url = url + "&month=" + month;
    location.href = url;
}
function deftym(year,month) {  //Current Year & Month
    url = "mcalen.php";
    url = url + "?year=" + year;
    url = url + "&month=" + month;
    location.href = url;
}

function memListSelect(p_strYear, p_strMonth) {
    var l_strUserID;    //User ID container.
    var l_strUrl;       //URL of the next page.

    //Retreive selected data's userid.
    l_strUserID = document.forms[0].memberSelectionList.value;

    //Check if a specific user is selected.
    if (l_strUserID != "  ") {

        l_strUrl = "usrschd.php";                       //url link
        l_strUrl = l_strUrl + "?uid=" + l_strUserID;    //user_id
        l_strUrl = l_strUrl + "&year=" + p_strYear;     //year
        l_strUrl = l_strUrl + "&month=" + p_strMonth;   //month

        location.href = l_strUrl;

    } else {
        return 0;
    }
    return 0;
}
</script>
</HEAD>
<BODY>
<?php
    require_once("header.php");
    print("<div id='content'> \n");
    print ("<FORM> \n");

  /* --------------------------- *
   *  URL パラメータを受け取る   *
   *  Update written 2018.02.09  *
   * --------------------------- */
    if(isset($_GET['year'])) {
        $year = $_GET['year'];
    }
    if(isset($_GET['month'])) {
        $month = $_GET['month'];
    }

    if(!isset($year)) {
	    if (isset($_SESSION["sCurYM"])) {
		    $year = $sCurYM[0];
		    $month = $sCurYM[1];
	    } else {
		    $today = getdate();
            $year = $today["year"];
            $month = $today["mon"];
	    }
    }
    if (($dyear == $year)&&($dmonth == $month)) {
        $wyear = $dyear;
        $wmonth = $dmonth;
    } else {
        $wyear = $year;
        $wmonth = $month;
    }
    if(!isset($_SESSION["sCurYM"])) {
	    $_SESSION["sCurYM"];
	    $sCurYM = array();
    }
    $sCurYM[0] = $year;
    $sCurYM[1] = $month;

// 週間カレンダー日付セット変数 unset
    if (isset($_SESSION["sCurMonday"])) {
        unset($_SESSION["sCurMonday"]);
    }
    if (isset($_SESSION["thisMonday"])) {
        unset($_SESSION["thisMonday"]);
    }
    if (isset($_SESSION["flag"])) {
        unset($_SESSION["flag"]);
    }
?>
<!-- Side Navigation Table -->
<div id="menu">
<TABLE border="0">
    <TBODY style="font-size:10pt">
        <TR><TD colspan="3">
            <IMG src="./resources/images/popase.gif" height="19" width="18" alt="me!">
            <?php
                print ("&nbsp");
                print ("<FONT size='-1' color='blue'>Login：</FONT><FONT size='-1' color='gray'>&nbsp; $sesjpname</FONT> \n"); 
            ?>
        </TD></TR>
        <TR><TD colspan="3">
            <?php
                print ("<P align='right'><FONT size='-1' color='blue'>メンバー：</FONT>
                <SELECT size='1' name='memberSelectionList' onchange=javascript:memListSelect('" . $year . "','" . $month . "')>\n");
                $l_objUserList = new usrlist();
                $l_objUserList->getUserList();
                print ("</SELECT> \n");
            ?>
        </TD></TR>
        <TR><TD>&nbsp;</TD></TR>
        <TR><TD>&nbsp;</TD></TR>
    </TBODY>
</TABLE>
 
</div>

<div id="main">
<?php
    if ($sesadmin == 1) {
        print ("<ul> \n");
        print ("<li><a href='mcalen.php' target='_top'><font color='#FFFFFF'>月間予定</font></a></li> \n");
        print ("<li><a href='wcalen.php' target='_top'><font color='#FFFFFF'>週間予定</font></a></li> \n");
        print ("<li><a href='todo.php' target='_top'><font color='#FFFFFF'>Todo登録</font></a></li> \n");
        //print ("<li><a href='http://kosei-halfmoon.dyndns-ip.com/gs/hotel.php' target='_blank'><font color='#FFFFFF'>
        print ("<li><a href='hotel.php' target='_blank'><font color='#FFFFFF'>
        ホテル検索</font></a></li> \n");
        print ("<li><a href='https://mail.google.com/mail/?account_id=kosei.halfmoon%40gmail.com#' target='_blank'><font color='#FFFFFF'>
        &nbsp;メール&nbsp;</font></a></li> \n");
        print ("</ul> \n");
        print ("<ul> \n");
        
        print ("<li><a href='userEntry.php' target='_top'><font color='#FFFFFF'>ユーザ登録&nbsp;[</FONT>
        <FONT color='red'><U>ExtJS</U></FONT><FONT color='#FFFFFF'>&nbsp;]</FONT></a></li> \n");
        
        print ("<li><a href='kwordEntry.php' target='_top'><font color='#FFFFFF'>キーワード登録&nbsp;[</font>
        <FONT color='red'><u>ExtJS</u></FONT><FONT color='#FFFFFF'>&nbsp;]</font></a></li> \n");
        
        print ("<li><a href='lout.php' target='_top'><font color='#FFFFFF'>ログアウト</font></a></li> \n");
        print ("</ul> \n");
    } else {
        print ("<ul> \n");
        print ("<li><a href='mcalen.php' target='_top'><font color='#FFFFFF'>月間予定</font></a></li> \n");
        print ("<li><a href='wcalen.php' target='_top'><font color='#FFFFFF'>週間予定</font></a></li> \n");
        print ("<li><a href='todo.php' target='_top'><font color='#FFFFFF'>Todo登録</font></a></li> \n");
        //print ("<li><a href='http://kosei-halfmoon.dyndns-ip.com/gs/hotel.php' target='_blank'><font color='#FFFFFF'>
        print ("<li><a href='hotel.php' target='_blank'><font color='#FFFFFF'>
        ホテル検索</font></a></li> \n");
        print ("<li><a href='lout.php' target='_top'><font color='#FFFFFF'>ログアウト</font></a></li> \n");
        print ("</ul> \n");
    } 
    print ("<a href='javascript:void(0)' onClick='backym($year,$month)'>
        <img src='./resources/images/icon_back.png' height='15' width='15'>&nbsp;前　月</a> \n");
    print ("<a href='javascript:void(0)' onClick='deftym($dyear,$dmonth)'>
        <img src='./resources/images/icon_now.png' height='15' width='15'>&nbsp;今　月</a> \n");
    print ("<a href='javascript:void(0)' onClick='fwdym($year,$month)'>
        <img src='./resources/images/icon_next.png' height='15' width='15'>&nbsp;次　月</a> \n");
    print ("<BR><BR> \n");

    $mschd = new mschd($year,$month);
    $mschd->set_calen();
    $mschd->disp_calen();
    print ("</FORM> \n");
?>
<img src="./resources/images/mini_b.gif" border="0"><FONT size="2" color="#3366FF">：予定あり</FONT>
</div>

 <!-- Rakuten Widget TO HERE -->
 <script type="text/javascript">
     rakuten_design="circle";
     rakuten_affiliateId="0d3a8fe2.76259a6d.0d3a8fe3.4d27d82b";
     rakuten_items="ctsmatch";
     rakuten_genreId=0;
     rakuten_size="148x500";
     rakuten_target="_blank";
     rakuten_theme="blue";
     rakuten_border="on";
     rakuten_auto_mode="on";
     rakuten_genre_title="off";
     rakuten_recommend="on";
     rakuten_ver="20100708";
 </script>
 <script type="text/javascript" src="http://xml.affiliate.rakuten.co.jp/widget/js/rakuten_widget.js">
 </script>
 <!-- Rakuten Widget TO HERE -->
 
 <!-- Facebook Badge START -->
 <TABLE border="0">
     <TBODY style="font-size:10pt">
         <TR><TD>&nbsp;</TD></TR>
         <TR><TD>
             <a href="https://www.facebook.com/naoshiw" target="_TOP" 
                 style="font-family: &quot;lucida grande&quot;,tahoma,verdana,arial,sans-serif; font-size: 11px; 
                 font-variant: normal; font-style: normal; font-weight: normal; color: #3B5998; text-decoration: 
                 none;" title="Naoshi Watanuki">Naoshi Watanuki</a><br/>
                 <a href="https://www.facebook.com/naoshiw" target="_TOP" title="Naoshi Watanuki">
                 <img src="https://badge.facebook.com/badge/100000754284072.2463.1504579258.png" style="border: 0px;" /></a><br/>
                 <a href="https://www.facebook.com/badges/" target="_TOP" 
                     style="font-family: &quot;
                             lucida grande&quot;,tahoma,verdana,arial,sans-serif; 
                             font-size: 11px; font-variant: normal; 
                             font-style: normal; font-weight: normal; 
                             color: #3B5998; text-decoration: none;" 
 title="&#x81ea;&#x5206;&#x3060;&#x3051;&#x306e;&#x30d0;&#x30ca;&#x30fc;&#x3092;&#x4f5c;&#x6210;&#x3057;&#x307e;&#x3057;&#x3087;&#x3046;&#x3002;">Create banner.</a>
         </TD></TR>
</div>
</BODY>
</HTML>
