<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : todo.php                                            |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php"); 
    require_once("footer.php"); //footer(outer file.)
    require_once("db_connect.php");
    $header_title = "[ ToDo一覧表 ]";

    if (isset($_SESSION["stodo"])) { 
        unset($_SESSION["stodo"]);
    } 
    if (isset($_SESSION["oldtodo"])) { 
        unset($_SESSION["oldtodo"]);
    }
    if (isset($_SESSION["stid"])) { 
        unset($_SESSION["stid"]);
    }
?>
<HTML>
<HEAD>
<TITLE>【ToDo登録／ToDo一覧表】</TITLE>
<META http-equiv="Content-Type" content="text/html;CHARSET=UTF-8">
<link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />
</HEAD>
<script type="text/javascript">
/*----------------------------------------------*
 *  確認と各phpファイルの実行をJavaScriptで行う *
 *----------------------------------------------*/
function todo_upd(tid) {  // TODOの変更
    url = "todoupd.php";
    url = url + "?tid=" + tid;
    location.href = url;
}
function todo_add() {  // TODOの追加
    url = "todoin.php";
    location.href = url;
}
function todo_del(tid) { // TODOの削除
/* 削除は2段構えに変更する。一覧の表示後に，
内容が変更されている可能性があるのでtododel.phpで再表示する。*/
    url = "tododel.php";
    url = url + "?tid=" + tid;
    location.href = url;
}
</script>
<BODY>
<?php require_once("header.php"); ?>
<div id="content">
<!-- <div id="header"> -->
<div id="menu">
<!-- Rakuten Widget FROM HERE -->
<script type="text/javascript">
    rakuten_design="circle";
    rakuten_affiliateId="0dc1804b.5057da97.0dc1804c.9a6c2953";
    rakuten_items="tra-ranking";
    rakuten_genreId="tra-allzenkoku";
    rakuten_size="148x500";
    rakuten_target="_blank";
    rakuten_theme="natural";
    rakuten_border="on";
    rakuten_auto_mode="on";
    rakuten_genre_title="on";
    rakuten_recommend="on";
    rakuten_service_flag="travel";
    rakuten_ver="20100708";
</script>
<script type="text/javascript" src="http://xml.affiliate.rakuten.co.jp/widget/js/rakuten_widget_travel.js">
</script>
<!-- Rakuten Widget TO HERE -->
</div>
<div id="main3">
<?php
    //SQL
    $sql = "select todotb.*,accounttb.jpname from todotb left join accounttb";
    $sql .= " on todotb.tuserid = accounttb.userid order by tdate";
    $res = mysqli_query($conn, $sql);
    
    print("<FORM><INPUT type='button' value='ToDo追加' onclick='todo_add()'><BR><BR> \n");
        
    print("<TABLE BORDER='2' CELLSPACING='1' CELLPADDING='1' 
            BORDERCOLORLIGHT='#000080' BORDERCOLORDARK='#3366CC' > \n");
    print("<TR height='12'> \n");
    print("<TD class='c4'>&nbsp;期　日</TD>
           <TD class='c4'>&nbsp;内　容</TD>
           <TD class='c4'>&nbsp;登録者</TD>
           <TD class='c4'>&nbsp;操　作</TD></TR> \n");

    while ($row = mysqli_fetch_array($res)) {
        $tid = $row["tid"];
        $tdate = $row["tdate"];
        $todo = $row["todo"];
        $crename = $row["jpname"];
        print("<TR class='c2'> \n");
        print("<TD>$tdate&nbsp;</TD> \n");
        print("<TD>$todo&nbsp;</TD> \n");
        print("<TD>$crename&nbsp;</TD> \n");  //書込んだ人の表示
        print("<TD> \n");

        print("&nbsp;<a href='javascript:void(0)' onClick='todo_upd($tid)'>
            <img src='./resources/images/mini_b.gif' height='16' width='16'><u>&nbsp;変更</u></a>&nbsp;");
        print("&nbsp;<a href='javascript:void(0)' onClick='todo_del($tid)'>
            <img src='./resources/images/ico_x.gif' height='11' width='11'><u>&nbsp;削除</u></a>&nbsp;");
        print("</TD></TR> \n");
    }
    print("</TABLE></FORM> \n");

    mysqli_free_result($res);
    mysqli_close($conn);

    //[$year,$month,$day]がURLパラメータとして渡ってこない場合の処理
    if (!isset($year)) {
        $today = getdate();
        $year = $today["year"];
        $month = $today["mon"];
        $day = $today["mday"];
    }
    print("<A href='mcalen.php?year=$year&month=$month'><img src='./resources/images/btn_home1_5.gif' height='15' width='40'></A> \n");
?>
</div>
</div>
</BODY>
</HTML>
