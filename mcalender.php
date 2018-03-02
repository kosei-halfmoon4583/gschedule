<?php
/* +======================================================================+
   | PHP version 4.2.1                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.15 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : mcalender.php (Base Class)                          |
   | DATA-WRITTEN   : 2002.07.15                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2007.12.07                                          |
   +======================================================================+ */
class mcalender{
    var $year;
    var $month;
    var $today;
    var $caleAry = array();
    var $youbiAry = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
    /*------------*
     *  bgcolor   *
     *------------*/
    var $bgctoday = " bgcolor = #99CCFF ";  //Background Color:本日
    var $bgcsatday =" bgcolor = white ";    //Background Color:土曜日
    var $bgcsunday =" bgcolor = white ";    //Background Color:日曜日
    var $bgcweekday = " bgcolor = white ";  //Background Color:その他の曜日
    /*--------------*
     *  font color  *
     *--------------*/
    //var $fctoday = "<FONT color = yellow>";
    var $fctoday = "<FONT color = 'blue'>";
    var $fcsatday ="<FONT color = blue>";
    var $fcsunday ="<FONT color = red>";
    var $fcweekday = "<FONT color = black>";
    /*---------------------------------------*
     *  Constractor                          *
     *---------------------------------------*/
    function mcalender($year, $month) {
        $this->today = getdate();  //今日の日付を取得
        $this->year = $year; 
        $this->month = $month; 
    }
    /*---------------------------------------*
     *   配列にカレンダーを作成              *
     *---------------------------------------*/
    function set_calen() {
        $set_day = 1;
        //曜日を取得する（月初1日の曜日を取得）
        $set_wday = date("w",mktime(0,0,0,$this->month,$set_day,$this->year));

     /* カレンダー表示形式をISO-8601 形式（1：月曜日～7：日曜日）で表示する */
        if ($set_wday == 0) {
            $set_wday = 6;
        } else {    
            $set_wday = $set_wday - 1;
        }
     /* 対象月の日数を取得する */
        $days = date("t",mktime(0,0,0,$this->month,$set_day,$this->year)); 

        $stop = "";
        for($i = 0; $i <= 5; $i++) {          //週0から5（最大6週まで）
            if($stop != "Stop") {
                for($j = 0; $j <= 6; $j++) {  //日0から6まで
                    if (($i == 0)&&($j < $set_wday)) { //月初めの処理
                        $this->caleAry[$i][$j] = "";
                    } else {
                        if ($set_day <= $days) {
                            $this->caleAry[$i][$j] = $set_day++;
                        } else {
                            $stop = "Stop";
                            $this->caleAry[$i][$j] = "";
                        }
                    }
                }
            }
        }
    }
    /*--------------------*
     *  カレンダーを表示  *
     *--------------------*/
    function disp_calen() {
        print( "<TABLE BORDER='1' CELLSPACING='1' CELLPADDING='2' BORDERCOLORLIGHT='#000080'
                 BORDERCOLORDARK='#3366CC'> \n"); 
        print( "<TR> \n");
        print( "<TH colspan='7' background='./resources/images/windows-bg.gif'>
                <FONT color='#FFFFFF' size='-1'>$this->year 年 $this->month 月</FONT></TH></TR> \n");
        print( "<TR> \n");

        foreach ($this->youbiAry as $youbi) {
            switch ($youbi) {
                case "Sat": //土曜日
                    print( "<TD class='c4'><B><FONT color='#0000FF'>$youbi</FONT></B></TD>");
                    break;
                case "Sun": //日曜日
                    print( "<TD class='c4'><B><FONT color='#FF0000'>$youbi</FONT></B></TD>");
                    break;
                default:
                    print( "<TD class='c4'><FONT color='#FFFFFF'>$youbi</FONT></TD>");
                    break;
            } 
        } 
        print( "</TR> \n");

        foreach ($this->caleAry as $week) {
            print( "<TR> \n");
            $j=0;
            foreach ($week as $draw_day) {
                print($this->set_string($draw_day,$j));
            }
            print( "</TR> \n");
        }
        print( "</TABLE> \n"); 
    }
    /*--------------------------------*
     *  bgcolor & font color Set      *
     *--------------------------------*/
    function set_string($dday,$youbi,$sesUserID) {
        if (($dday == $this->today["mday"])&&($this->month == $this->today["mon"])
            &&($this->year == $this->today["year"])) {
            return ("<TD" . $this->bgctoday . "align=right>" .$this->fctoday . $dday . "</TD> \n");
        }
        if (empty($dday)) {
            return ("<TD" . $this->bgcweekday . "align=right>" .$this->fcweekday . $dday . "</TD> \n"); 
        }
        switch ($youbi) { // wday:曜日（0～6:日から土）
            case 5: //土曜日
                return ("<TD" . $this->bgcsunday . "align=right>".$this->fcsatday . $dday . "</TD> \n"); 
            case 6: //日曜日
                return ("<TD" . $this->bgcsatday . "align=right>".$this->fcsunday .  $dday . "</TD> \n"); 
            default:
                return ("<TD" . $this->bgcweekday . "align=right>".$this->fcweekday . $dday . "</TD> \n"); 
        }
    }
}
?>
