<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : login.php                                           |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>Schedule Management System</title>
<link rel="stylesheet" href="./resources/css/styles-site.css" type="text/css" />
</head>
<body id="index" onLoad="document.login_form.frmuserid.focus()">
<div id="container">
<div id="header">
    <h1>kosei-halfmoon</h1>
    <?php $wdate = date("Y-m-d"); ?>
</div>

<div id="center">
<div class="content">
    <form name="login_form" action="loginsub.php" method="POST">
        <h2>Login</h2>
            <?php print("<p>Today：&nbsp;$wdate</p> \n"); ?>
        <dl>
            <dt>ユーザーID</dt><dd><input type="text" name="frmuserid" /></dd>
            <dt>パスワード</dt><dd><input type="password" name="frmpasswd" /></dd>
        </dl>
        <input type="image" name="login" width="101" height="40" src="./resources/images/bg.gif" class="singnin" />
    </form>
</div>
</div>

<div id="footer">
<p>Schedule Management System Version 2.2.4<br />Copyright(C). 2019 N.Watanuki. Allright Reserved.</p>
</div>
</div>
</body>
</html>
