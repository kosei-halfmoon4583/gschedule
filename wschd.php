<?php
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.08.07 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : wschd.php                                           |
   | DATA-WRITTEN   : 2002.08.07                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2007.12.14                                          |
   +======================================================================*/
    require_once("wcalender.php");  // wcalender 月間カレンダーを作成するクラス

/*----------------------------*
 * wcalender Classを継承する  *
 *----------------------------*/
class wschd extends wcalender {
    /*------------------*
     * Constractor      *
     *------------------*/
    function wschd($year, $month, $day) {
        $this->connectDB();
        $this->wcalender($year, $month, $day); //Calendar Instance generates.
    }
    /*--------------------*
     *  DB Connect(MySQL) *
     *--------------------*/
     function connectDB() {
        //define("DBSV", "localhost");
        define("DBSV", "127.0.0.1");
        define("DBNAME", "gschedule");
        define("DBUSER", "nao");
        //define("DBPASS", "naow2696");
        define("DBPASS", "naow4583");

        $conn = mysql_connect(DBSV, DBUSER, DBPASS) or 
            die("Could not connect to Database!: " . mysql_error($conn));
        mysql_select_db(DBNAME, $conn);
    }
    /*------------------------------------------*
     *  基底クラスのdisp_calenをオーバーロード  *
     *------------------------------------------*/
    function disp_calen() {

        //$nweeks = date("W"); //How many weeks have been past from beginning of the year?

        print( "<TABLE BORDER='1' CELLSPACING='1' 
                 CELLPADDING='2' BORDERCOLORLIGHT='#000080' BORDERCOLORDARK='#3366CC'> \n"); 

        print( "<TR> \n");
        print("<TD align='center' colspan='7' nowrap background='./resources/images/windows-bg.gif'>
                <FONT color='#FFFFFF' size='-1'>$this->year 年 $this->month 月 $this->day 日&nbsp;から始まる週です
                </FONT></TD></TR> \n");

/*
        print("<TD align='center' colspan='7' nowrap background='./resources/images/windows-bg.gif'>
            <FONT color='#FFFFFF' size='-1'>第&nbsp;$nweeks&nbsp;週&nbsp;
            （$this->year 年 $this->month 月 $this->day 日&nbsp;→）
            </FONT></TD></TR> \n");

*/        
        print( "</TR> \n");

        print( "<TR> \n");
        for($i = 0; $i <= 6; $i++) {
            $draw_day = getdate(mktime(0,0,0,$this->month,$this->day + $i,$this->year)); 
            print($this->set_string($draw_day,$i));
        }
        print( "</TR> \n");
        print( "<TR> \n");
        for($i = 0; $i <= 6; $i++) {
            $draw_day = getdate(mktime(0,0,0,$this->month,$this->day + $i,$this->year)); 
            print($this->set_content($draw_day,$i));
        }
        print( "</TR> \n");
        print( "</TABLE> \n"); 
    } 
    /*----------------------------------------*
     *  追加したメソッド                      *
     *----------------------------------------*/
    function set_content($dday,$i) {

        //MySQL DB Connect
        //define("DBSV", "localhost");
        define("DBSV", "127.0.0.1");
        define("DBNAME", "gschedule");
        define("DBUSER", "nao");
        //define("DBPASS", "naow2696");
        define("DBPASS", "naow4583");

        $conn = mysql_connect(DBSV, DBUSER, DBPASS) or 
            die("Could not connect to Database!: " . mysql_error($conn));
        mysql_select_db(DBNAME, $conn);

        $year=$dday["year"];
        $month=$dday["mon"];
        $day=$dday["mday"];
        // schdtbテーブルから一日の予定を取得
        $cond =$year ."/" .$month ."/"  .$day;
        $sql = "SELECT sid, sstime, setime, cont1 FROM schdtb where sdate = '$cond'"
             . " ORDER by sstime";
        $res = mysql_query($sql, $conn);
        $nrow = mysql_num_rows($res);  

        $strRet = "<TD bgcolor='#FFFFFF' valign='top'>";
        $strRet .= "<A href='schdin.php?year=$year&month=$month&day=$day&flag=2'>";
        
        if($nrow == 0) {
            $strRet .= "<IMG src='./resources/images/sfa2_b.gif' border='0'>";
        } else {
            $strRet .= "<IMG src='./resources/images/mini_b.gif' border='0'>";
        }
        $strRet .= "</A><BR>";

        if($nrow == 0) {
            $strRet .= "</TD>";
            return($strRet);
        }

        while ($row = mysql_fetch_assoc($res)) { 
            $sid =$row["sid"];
            $sstime = $row["sstime"];
            $setime = $row["setime"];
            $cont1 = $row["cont1"];
            // 時分を時間と分に分割
            $sshour = substr($sstime,0,2);
            $ssmin = substr($sstime,2,2);
            $dstime = $sshour .":" . $ssmin;
            $sehour = substr($setime,0,2);
            $semin = substr($setime,2,2);
            if (trim($sehour) <> "") {
                $detime = $sehour .":" . $semin;
            } else {
                $detime = "";
            }
            $strRet .= "<A href='schdupd.php?sid=$sid&year=$year&month=$month&day=$day&flag=2'>";
            $strRet .= $dstime ."～" .$detime ."<BR>" .$cont1 ."</A><BR>";
        }
        $strRet .= "</TD>";
        return($strRet);
    }
}
?>
