<?php
/* +========================================================================+
   | PHP version 4.4.2                                                      |
   +------------------------------------------------------------------------+
   | Copyright (C) 2002.08.30 L. Tortona                                    |
   +------------------------------------------------------------------------+
   | Script-ID      : usrschd.php                                           |
   | DATA-WRITTEN   : 2002.09.02                                            |
   | AUTHOR         : __________                                            |
   | UPDATE-WRITTEN : 2007.12.09 UPDATE AUTHER: Naoshi WATANUKI.            |
   +========================================================================*/
    require_once("usrschddb.php");
    require_once("footer.php"); //footer(outer file.)
    $header_title = "[ ユーザ別予定一覧表 ]";

    //Update 2018.02.18 usetに変更
    //Check for session information
    /*
    if (isset($s_usrschd)) { 
        session_unregister("s_usrschd");
    }
    if (isset($s_old_usrschd)) { 
        session_unregister("s_old_usrschd");
    } 
    if (isset($stid)) { 
        session_unregister("stid");
    }
    */
    if (isset($s_usrschd)) { 
        unset("s_usrschd");
    }
    if (isset($s_old_usrschd)) { 
        unset("s_old_usrschd");
    } 
    if (isset($stid)) { 
        unset("stid");
    }
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
<!-- <div id="header"> -->
<div id="menu-ad">
<PRE style="color:#3399CC;">
 [ 広告エリア ]
</PRE>
</div>

<div id="main3">
<FORM method="POST">
    <TABLE border="0" width="650" height="40">
        <TR><TD width="100" height="40"><B><FONT size="2">メンバー：</FONT></B></TD>
<?php
        //Check if variables were completely passed.
        if ( isset($uid) && isset($year) && isset($month) ) {
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
?> 
        </TR>
    </TABLE>
    <TABLE border="0" width="650" height="63">
        <TR><TD>
            <A href="mcalen.php"><img src="./resources/images/btn_home1_5.gif" height="15" width="40"></A>
        </TD></TR>
    </TABLE>
</FORM>
</div>
</div>
</BODY>
</HTML>
