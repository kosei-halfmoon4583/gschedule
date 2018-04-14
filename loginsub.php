<?php
session_start();         
  /*======================================================================+
   | PHP version 5.6.30                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.16 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : loginsub.php                                        |
   | DATA-WRITTEN   : 2002.07.16                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2011.04.05                                          |
   | UPDATE-WRITTEN : 2018.0302 Upgrade to a newer version.               |
   +======================================================================*/
    require_once("db_connect.php");
    require_once("footer.php"); 

    $frmuserid = $_POST['frmuserid'];
    $frmpasswd = $_POST['frmpasswd'];

    //Admin,jpname 追加 for group
    $sql = "SELECT passwd,admin,jpname FROM accounttb WHERE userid = '$frmuserid'";
    $res = mysql_query($sql, $conn);
    $nbrows = mysql_num_rows($res);  

    if($nbrows == 0) {
        print ("<HTML> \n");
        print ("<HEAD> \n");
        print ("<META http-equiv='Content-Type' content='text/html;CHARSET=UTF-8'> \n");
        print ("<link rel='stylesheet' type='text/css' href='./resources/css/gs.css' /> \n");
        print ("<TITLE>ログインIDエラー</TITLE> \n");
        print ("</HEAD> \n");
        print ("<BODY> \n");
        print ("<div id='content'> \n");
        $header_title = "[ Login ID Error! ]";
        require_once("header.php");
        print ("<div id='menu'> \n");
        print ("<pre style='color:#FFFFFF;'>.</pre> \n");
        print ("</div> \n");
        print ("<div id='main3'> \n");    
        print ("<FONT color='red'>ログインIDが違います。$frmuserid</FONT><BR><BR>");
        print ("<A href='login.php'><U>再ログインしてください</U></A>");
        print ("</div> \n");
        print ("</div> \n");
        print ("</BODY> \n");
        print ("</HTML> \n");
        session_destroy();
        exit();
    }

    $nbrows = mysql_fetch_array($res);
    if ($nbrows[0] != $frmpasswd) {
        print ("<HTML> \n");
        print ("<HEAD> \n");
        print ("<META http-equiv='Content-Type' content='text/html;CHARSET=UTF-8'> \n");
        print ("<link rel='stylesheet' type='text/css' href='./resources/css/gs.css' /> \n");
        print ("<TITLE>ログインPasswordエラー</TITLE> \n");
        print ("</HEAD> \n");
        print ("<BODY> \n");
        print ("<div id='content'> \n");
        $header_title = "[ Login Password Error! ]";
        require_once("header.php");
        print ("<div id='menu'> \n");
        print ("<pre style='color:#FFFFFF;'>.</pre> \n");
        print ("</div> \n");
        print ("<div id='main3'> \n");    
        print ("<FONT color='red'>パスワードが違います。</FONT><BR><BR>");
        print ("<A href='login.php'><U>再ログインしてください</U></A>");
        print ("</div> \n");
        print ("</div> \n");
        print ("</BODY> \n");
        print ("</HTML> \n");
        session_destroy();
        exit();
    }

    mysql_free_result($res);
    mysql_close($conn);

    // Update 2018/02/04 from 'session_register() to $_SESSION['']  
    $_SESSION["sesLoginID"] = $frmuserid;
    $_SESSION["sesadmin"] = $nbrows[1];
    $_SESSION["sesjpname"] = $nbrows[2];

    header("Location:mcalen.php");
    exit();
?>
