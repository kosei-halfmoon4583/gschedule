<?php
session_start();
    /*======================================================================+
     | PHP version 7.1.16                                                   |
     +----------------------------------------------------------------------+
     | Copyright (C) 2019.02.11 N.Watanuki                                  |
     +----------------------------------------------------------------------+
     | Script-ID      : login.php                                           |
     | DATA-WRITTEN   : 2019.02.11                                          |
     | AUTHER         : _.________                                          |
     | UPDATE-WRITTEN : ____.__.__                                          |
     +======================================================================*/
    echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Schedule Management.</title>
        <link rel="stylesheet" type="text/css" 
            href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./resource/css/sticky-footer.css" />

        <script type="text/javascript">
        </script>
    </head>

<body>
    <?php $wdate = date("Y-m-d"); ?>
    <div class="container">
    <div class="page-header">
        <h3><a href=""> Schedule Management System.
            <!--
            <small>version 2.2.17<font color="#FFFFFF">.</font><font color="#000080">[&nbsp;<?php print("<p>Today：&nbsp;$wdate</p> \n"); ?>&nbsp;]</font></small>
            -->
            <small>&nbsp;version 2.2.4<font color="#FFFFFF">...</font><font color="#000080">[&nbsp;<?php print("Today：&nbsp;$wdate \n"); ?>&nbsp;]</font></small>
            </a>
        </h3>
    </div>
    <h4>Please Signin !</h4><br>
    <form action="loginsub.php" method="POST">
        <table>
            <tr>
                <td>UserID:&nbsp;</td>
                <td><input type="text" name="frmuserid" placeholder="Your UserID" /></td>
            </tr>
            <tr>
                <td>Password:&nbsp;</td>
                <td><input type="password" name="frmpasswd" placeholder="Your Password" /></td>
            </tr>
            </table><br>
            <button type="submit" class="btn btn-sm btn-primary">Sign in</button>&nbsp;
            <button type="reset" class="btn btn-sm btn-primary">reset</button>
    </form>
    </div>
    <BR><BR>
    
    <!-- Footer Include --> 
    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright(C). 2019 Naoshi WATANUKI Allright Reserved.</p>
        </div>
    </footer>
</body>
</html>
