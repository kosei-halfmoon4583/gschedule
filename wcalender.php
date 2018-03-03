<?php
/* +======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.08.03 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : wcalender.php                                       |
   | DATA-WRITTEN   : 2002.08.03                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : ____.__.__                                          |
   +======================================================================*/
class wcalender { 
    var $year;
    var $month;
    var $day;
    var $today;
    var $youbiAry = array("月","火","水","木","金","土","日");
    /*-----------*
     *  bgcolor  *
     *-----------*/
    var $bgctoday = " bgcolor = #99CCFF ";
    var $bgcsatday =" bgcolor = white ";
    var $bgcsunday =" bgcolor = white ";
    var $bgcweekday = " bgcolor = white ";
    /*--------------*
     *  font color  *
     *--------------*/
    var $fctoday = "<font color = blue>";
    var $fcsatday = "<font color = blue>";
    var $fcsunday = "<font color = red>";
    var $fcweekday = "<font color = white>";
    /*---------------------------------------*
     *  Constractor                          *
     *---------------------------------------*/
    function wcalender($year, $month, $day) {
        $this->today = getdate();  //今日の日付を取得
        $this->year = $year; 
        $this->month = $month; 
        $this->day = $day; 
    }
    /*---------------------------------------*
     *  カレンダーを表示                     *
     *---------------------------------------*/
    function disp_calen() {
        print("<TABLE BORDER='1' CELLSPACING='1' CELLPADDING='2' 
            BORDERCOLORLIGHT='#000080' BORDERCOLORDARK='#3399CC'> \n"); 
        print("<TR> \n");
         
        print("<TH colspan='7' nowrap background='./resources/images/windows-bg.gif'>
            <FONT color='#FFFFFF' size='-1'>$this->year 年 $this->month 月 $this->day 日から始まる週です
            </FONT></TH></TR> \n");
        print("<TR> \n");
        for($i = 0; $i <= 6; $i++) {
            $draw_day = getdate(mktime(0,0,0,$this->month,$this->day + $i,$this->year));    
            print($this->set_string($draw_day,$i));
        }
        print("</TR> \n");
        print("</TABEL> \n"); 
    }
    /*------------------------------*
     * bgcolor & font color set     *
     *------------------------------*/
    function set_string($dday,$i) {
        $year=$dday["year"];
        $month=$dday["mon"];
        $day=$dday["mday"];

        if (($day == $this->today["mday"])&&($month == $this->today["mon"])
           &&($year == $this->today["year"])) { 
            return ("<TD background='./resources/images/win-bg.gif align=left><FONT size='12px'>"  .$this->fctoday
            .$month ."月" .$day ."日" . "（" .$this->youbiAry[$i] ."）" ."</FONT></TD> \n");
        }
/*
        switch ($i) {  // wday:曜日（0～6:月から日）
            case 5:  // 土曜日
                return ("<TD" . $this->bgcsatday . "><FONT size='-1'>" .$this->fcsatday 
                    .$month ."月" .$day ."日" ."（" .$this->youbiAry[$i] ."）" ."</FONT></TD> \n");
            case 6:  // 日曜日
                return ("<TD" . $this->bgcsunday . "><FONT size='-1'>" .$this->fcsunday 
                    .$month ."月" .$day ."日" ."（" .$this->youbiAry[$i] ."）" ."</FONT></TD> \n");
            default:
                return ("<TD" . $this->bgcweekday . "><FONT size='-1'>" .$this->fcweekday 
                    .$month ."月" .$day ."日" ."（" .$this->youbiAry[$i] ."）" ."</FONT></TD> \n");
        }
*/
       /*==================================================*
        * Sample Logic (Don't delete!)                     *
        *==================================================*/
        switch ($i) {  // wday:曜日（0～6:月から日）
            case 5:  // 土曜日
                return ("<TD class='c4'>" .$this->fcsatday 
                    .$month ."月" .$day ."日" ."（" .$this->youbiAry[$i] ."）" ."</TD> \n");
            case 6:  // 日曜日
                return ("<TD class='c4'>" .$this->fcsunday 
                    .$month ."月" .$day ."日" ."（" .$this->youbiAry[$i] ."）" ."</TD> \n");
            default:
                return ("<TD class='c4'>" .$this->fcweekday 
                    .$month ."月" .$day ."日" ."（" .$this->youbiAry[$i] ."）" ."</TD> \n");
        }
    }
}
?>
