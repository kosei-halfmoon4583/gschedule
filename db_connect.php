<?php
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : db_connect.php                                      |
   | DATA-WRITTEN   : 2019.03.02                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : ____.__.__                                          |
   +======================================================================*/
    //MySQL DB Connect
    define("DBSV", "127.0.0.1");
    define("DBNAME", "gschedule");
    define("DBUSER", "nao");
    define("DBPASS", "naow4583");

    /*
    $conn = mysql_connect(DBSV, DBUSER, DBPASS) or 
        die("Error: Could not connect to Database!: " . mysql_error($conn));
    mysql_select_db(DBNAME, $conn);
    */
    $conn = mysqli_connect(DBSV,DBUSER,DBPASS,DBNAME);
    if(mysqli_connect_error()) {
        die("Error: DBへの接続に失敗しました！" . mysqli_error($conn));
    }
?>
