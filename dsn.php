<?php
/* +======================================================================+
   | PHP version 4.2.1                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.24 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Database Connect Script                                              |
   | Script-ID      : dsn.php                                             |
   | DATA-WRITTEN   : 2002.02.24                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2007.12.06                                          |
   |                                                                      |
   | DSN DB接続文字列をiniファイルから読み込む                            |
   | (*データベース接続情報を隠すため)                                    |
   |                                                                      |
   | *注意                                                                |
   |  このSource Codeの[$fp=fopen...]は、Linux用です。Windowsの場合は、   |
   |  下記の[$fp=fopen]のコメントを変更すること                           |
   |  $fp = fopen('/usr/local/apache2/htdocs/gs/config/gscdsn.ini','r');  |
   +======================================================================+ */
    function get_dsn() {
        $fp = fopen("C:\Apache2\htdocs\gs\config\gscdsn.ini","r");  // for Windows
        //$fp = fopen('/usr/local/apache2/htdocs/gs/config/gscdsn.ini','r'); /* for Linux */
        if ( $fp == false ){
            die("dsn設定ファイルが見つかりません！");
        }
        $dsn = trim(fgets($fp,255));
        fclose($fp);
        return $dsn;
    }

  /* DBMSܹԤ˴ؤ・unctionﾊFor Test 2008/01/25) */
    function get_opt() {
        $options = array(
            'debug'       => 2,
            'portability' => DB_PORTABILITY_ALL,
        );
        return $option;
    }
?>
