<?php
  /*==========================================================================+
   | PHP version 4.4.2                                                        |
   +--------------------------------------------------------------------------+
   | Copyright (C) 2002.07.16 N.watanuki                                      |
   +--------------------------------------------------------------------------+
   | Script-ID      : mcalen.php                                              |
   | DATA-WRITTEN   : 2002.07.15                                              |
   | AUTHER         : N.WATANUKI                                              |
   | UPDATE-WRITTEN : 2011.02.04 Naoshi Watanuki.                             |
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
