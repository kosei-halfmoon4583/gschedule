<?php
  /*==========================================================================+
   | PHP version 7.1.16                                                       |
   +--------------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                      |
   +--------------------------------------------------------------------------+
   | Script-ID      : header.php                                              |
   | DATA-WRITTEN   : 2018.07.25                                              |
   | AUTHER         : _._________                                             |
   | UPDATE-WRITTEN : 2019.03.12                                              |
   +==========================================================================*/
/* [ Initial Setup. ] */
    $crrentdate = getdate();
    $dyear = $crrentdate["year"];
    $dmonth = $crrentdate["mon"];
    $wdate = date("Y-m-d");
    $wday = $crrentdate["wday"];
    $wdeAry = array("( Sun.)","( Mon.)","( Tue.)","( Wed.)","( Thu.)","( Fri.)","( Sat.)");

    print("<div id='header'> \n"); 
    $wdate = date("Y-m-d");

/* [header title ] */
    print("<div id='today' style='position:absolute; top:6px; left:18px; font-size:12px'>
        <img src='./resources/images/today.png' height='39' width='247'></div> \n");
    print("<div id='date' style='position:absolute; top:22px; left:124px; font-size:13px; color:#0099FF'>$wdate</div> \n");
    if($wday == 0) { /* Sunday will TEXT Color Red. */
        print("<div id='date' style='position:absolute; top:22px; left:205px; font-size:13px; color:#FF0000'>$wdeAry[$wday]</div> \n");
    } else {
        print("<div id='date' style='position:absolute; top:22px; left:205px; font-size:13px; color:#0099FF'>$wdeAry[$wday]</div> \n");
    }
    print("<div id='date' style='position:absolute; top:22px; left:274px; font-size:13px'>$header_title</div> \n");

/* [ header line ] */
    print("<div id='line-top'><HR SIZE='1' color='#224782'></div> \n"); 
    print("</div> \n"); 
?>
