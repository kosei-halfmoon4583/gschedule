<?php
/* +========================================================================+
   | PHP version 7.1.16                                                     |
   +------------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                    |
   +------------------------------------------------------------------------+
   | Script-ID      : usrschd.php                                           |
   | DATA-WRITTEN   : 2018.07.25                                            |
   | AUTHOR         : _.________                                            |
   | UPDATE-WRITTEN : 2019.03.12                                            |
   +========================================================================*/
    require_once("usrschddb.php");
    require_once("footer.php"); //footer(outer file.)
    $header_title = "[ ユーザ別予定一覧表 ]";
    $today = array();
    $year = "";
    $month = "";
    $uid = "";

    if (isset($s_usrschd)) { 
        // unset("s_usrschd");
        unset($s_usrschd);
        // unset($_SESSION["s_usrschd"]);
    }
    if (isset($s_old_usrschd)) { 
        // unset("s_old_usrschd");
        unset($s_old_usrschd);
        // unset($_SESSION["s_old_usrschd"]);
    } 
    if (isset($stid)) { 
        // unset("stid");
        unset($stid);
        // unset($_SESSION["stid"]);
    }

    // URLパラメータを受け取る
    $year = $_GET["year"];
    $month = $_GET["month"];
    $uid = $_GET["uid"];
?>
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>【メンバー別予定一覧表】</TITLE>
<link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />
</HEAD>
<BODY>
<?php require_once("header.php"); ?>
<div id="content">
<div id="menu-ad">
<PRE style="color:#3399CC;">
 [ 広　告 ]
</PRE>
</div>

<div id="main3">
<FORM method="POST">
    <TABLE border="0" width="650" height="40">
        <TR><TD width="100" height="40"><B><FONT size="2">登録者：</FONT></B></TD>
<?php
    //Check if variables were completely passed.
    if (isset($uid) && isset($year) && isset($month) ) {
        //Instantiate class for retrieval of user's data.
        $l_objUsrSched = new usrschddb();
        //Retrieve and display user data for the month...
        $l_objUsrSched->getUserData($uid, $year, $month);
    } else {
        print ("</TABLE> \n");
        print ("<div align='center'> \n");
        print ("Kindly pass the correct data to access this screen. \n");
        print ("</div> \n");
    }
    print("</TR> \n");
    print("</TABLE> \n");

    print("<TABLE border='0' width='650' height='63'> \n");
    print("<TR><TD> \n");
    print("<A href='mcalen.php?year=$year&month=$month'><img src='./resources/images/btn_home1_5.gif' height='15' width='40'></A> \n");
    print("</TD></TR> \n");
    print("</TABLE> \n");
?>
</FORM>
</div>
</div>
</BODY>
</HTML>
