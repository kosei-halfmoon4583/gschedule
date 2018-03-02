<?php
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2011.04.05 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : db_connect.php                                      |
   | DATA-WRITTEN   : 2011.04.05                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : ____.__.__                                          |
   +======================================================================*/
    //MySQL DB Connect
    //define("DBSV", "localhost");
    define("DBSV", "127.0.0.1");
    define("DBNAME", "gschedule");
    define("DBUSER", "nao");
    define("DBPASS", "naow4583");

    $conn = mysql_connect(DBSV, DBUSER, DBPASS) or 
        die("Error: Could not connect to Database!: " . mysql_error($conn));
    mysql_select_db(DBNAME, $conn);
?>
