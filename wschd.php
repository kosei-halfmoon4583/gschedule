<?php
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : wschd.php                                           |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : N.watanuki                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("wcalender.php");  // wcalender 月間カレンダーを作成するクラス
    require_once("db_connect.php");  // Database connect.

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

         $conn = mysqli_connect(DBSV, DBUSER, DBPASS, DBNAME);
         if(mysqli_connect_error()){
             die("Could not connect to Database!: " . mysqli_error($conn));
         }
    }
    /*------------------------------------------*
     *  基底クラスのdisp_calenをオーバーロード  *
     *------------------------------------------*/
    function disp_calen() {

        // 週の始まり（第何週か？）を表示するための変数：$nweeks
        // $nweeks = date("W"); //How many weeks have been past from beginning of the year?

        print( "<TABLE BORDER='0' CELLSPACING='1' BORDERCOLORLIGHT='#000080' BORDERCOLORDARK='#3366CC'> \n"); 
        print( "<TR> \n");
        print("<TD align='center' colspan='7' nowrap background='./resources/images/windows-bg.gif'>
                <FONT color='#FFFFFF' size='-1'>&nbsp;$this->year 年 $this->month 月 $this->day 日&nbsp;から始まる週です&nbsp;</FONT> \n");
        print("</TD></TR> \n");
        // Dummy table row here
        print("<TR><TD><FONT color='#FFFFFF'>.</FONT></TD></TR> \n");
        print("</TABLE> \n");
        /*
        print( "<TR> \n");
        print("<TD align='center' colspan='7' nowrap background='./resources/images/windows-bg.gif'>
            <FONT color='#FFFFFF' size='-1'>&nbsp;第&nbsp;$nweeks&nbsp;週&nbsp;
            （$this->year 年 $this->month 月 $this->day 日&nbsp;→）
            </FONT></TD></TR> \n");
        print("</TABLE> \n");
        */
        print( "<TABLE BORDER='1' CELLSPACING='1' 
                 CELLPADDING='2' BORDERCOLORLIGHT='#000080' BORDERCOLORDARK='#3366CC'> \n"); 
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

        $conn = mysqli_connect(DBSV, DBUSER, DBPASS, DBNAME);
        if(mysqli_connect_error()){
            die("Could not connect to Database!: " . mysqli_error($conn));
        }

        $year=$dday["year"];
        $month=$dday["mon"];
        $day=$dday["mday"];
        // schdtbテーブルから一日の予定を取得
        $cond =$year ."/" .$month ."/"  .$day;
        $sql = "SELECT sid, sstime, setime, cont1 FROM schdtb where sdate = '$cond'"
             . " ORDER by sstime";
        $res = mysqli_query($conn, $sql);
        $nrow = mysqli_num_rows($res);  

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

        while ($row = mysqli_fetch_assoc($res)) { 
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
