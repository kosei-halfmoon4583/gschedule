<?php
session_start();
/* +======================================================================+
   | PHP version 5.6.30                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.16 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : mschd.php                                           |
   | DATA-WRITTEN   : 2006.11.29                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2011.04.06                                          |
   | UPDATE-WRITTEN : 2018.03.08 Upgrade to a newer version.              |
   +======================================================================+  */
    require_once("sschk.php");
    require_once("mcalender.php");  //mcalender月刊カレンダーを作成するクラス
/*----------------------------*
 * mcalenderクラスを継承する  *
 *----------------------------*/
class mschd extends mcalender {
    var $href;
    var $content;
    var $sesUserID;
    /*------------------*
     *  Constractor     *
     *------------------*/
    function mschd($year, $month) {
        require_once("db_connect.php");
        $this->mcalender($year, $month);
        $sesUserID = $uid;
    }
    /*--------------------------------*
     *  bgcolor & font color set      *
     *--------------------------------*/
    function set_string($dday,$youbi) {
        if (empty($dday)) {
            $this->content = "</FONT></TD>";
        } else {
            $this->content = $this->get_schd($dday) . "</A></FONT></TD>";
        }
        
     /* カレンダーの本日のBackground imageを設定する */
        if (($dday == $this->today["mday"])&&($this->month == $this->today["mon"])
            &&($this->year == $this->today["year"])) {
            
            if (isset($_SESSION["sesLoginID"])) {
                $sesUserID = $_SESSION["sesLoginID"];
            } else {
                $sesLoginID = "wata";
            }
            return ("<TD width = '60' valign = 'top' background='./resources/images/win-bg.gif align=left><FONT size='-1'>
                    <A href='testPOST.php?year=$this->year&month=$this->month&day=$dday&uid=$sesUserID' target='_blank'>" 
            .$this->fctoday . $dday . $this->content ."\n");
        }
        
        if (empty($dday)) {
            return ("<TD width = '60' valign = 'top'" . $this->bgcweekday . "align=left><FONT size='-1'>" 
            .$this->fcweekday . $dday . $this->content ."\n");
        }
        
        switch ($youbi) {  //wday:曜日（0～6:日から土）
            case 5:  //土曜日
                return ("<TD width = '60' valign = 'top'" . $this->bgcsatday . "align=left><FONT size='-1'>
                    <A href='testPOST.php?year=$this->year&month=$this->month&day=$dday&uid=$sesUserID' target='_blank'>" 
                    . $this->fcsatday . $dday . $this->content ."\n");
            case 6:  //日曜日
                return ("<TD width = '60' valign = 'top'" . $this->bgcsunday . "align=left><FONT size='-1'>
                    <A href='testPOST.php?year=$this->year&month=$this->month&day=$dday&uid=$sesUserID' target='_blank'>" 
                    . $this->fcsunday .  $dday . $this->content ."\n");
            default:
                return ("<TD width = '60' valign = 'top'" . $this->bgcweekday . "align=left><FONT size='-1'>
                    <A href='testPOST.php?year=$this->year&month=$this->month&day=$dday&uid=$sesUserID' target='_blank'>" 
                    .$this->fcweekday . $dday . $this->content ."\n");
        }
    }
    function get_schd($dday) { /* schedtbテーブルから一日の予定を取得 */

        $conn = mysql_connect(DBSV, DBUSER, DBPASS) or 
            die("Could not connect to Database!: " . mysql_error($conn));
        mysql_select_db(DBNAME, $conn);

        $cond =$this->year . "/" .$this->month . "/" .$dday;
        $sql = "SELECT sstime, cont1, suserid FROM schdtb WHERE sdate = '$cond' ORDER by sstime";

        //$sql = "SELECT sstime, cont1 FROM schdtb WHERE (sdate = '$cond') and (suserid = '$sesUserID')"
        // . " order by sstime";

        $res = mysql_query($sql, $conn);
        $nrow = mysql_num_rows($res);  

        $strRet = "<BR>";
        if($nrow == 0) {
            $strRet .= "<A href='schdin.php?year=$this->year&month=$this->month&day=$dday&flag=1'>";
            $strRet .= "<img src='./resources/images/page_attach.png' align='right' border='0'>";
            $strRet .= "</A><BR>";
            return($strRet);
        } else {
            $strRet .= "<A href='schd.php?year=$this->year&month=$this->month&day=$dday'>";
            $strRet .= "<img src='./resources/images/mini_b.gif' align='right' border='0'>";

    /*--- [ UPDATE: 2007/12/07 N.watanuki下記のロジックは削除不可！------*
           予定を登録したとき、予定があることが一目で分かるように
           カレンダーの日付枠に予定時間を表示するためのLogicです。

            //while ($row = $res->fetchRow( DB_FETCHMODE_ASSOC )) {
            while ($nrow = mysql_num_rows($res)) {
                $sstime = $nrow["sstime"];
                $cont1 = $nrow["cont1"];
                //時分を時間と分に分割
                $sshour = substr($sstime,0,2);
                $ssmin = substr($sstime,2,2);
                $dstime = $sshour .":" . $ssmin;
                $strRet .= $dstime .$cont1 ."<BR>";
            } 
            $strRet .= "</FONT>";
     *--------------------------------------------------------------------*/
        }
        return($strRet);
    }
}
?>
