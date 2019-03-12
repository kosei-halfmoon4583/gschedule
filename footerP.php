<?php
  /*==========================================================================+
   | PHP version 7.1.16                                                       |
   +--------------------------------------------------------------------------+
   | Copyright (C) 2014.05.30 N.watanuki                                      |
   +--------------------------------------------------------------------------+
   | Script-ID      : footerP.php                                             |
   | DATA-WRITTEN   : 2014.05.30                                              |
   | AUTHER         : N.WATANUKI                                              |
   | UPDATE-WRITTEN : 2019.03.12                                              |
   +==========================================================================*/
   $Agent = getenv( "HTTP_USER_AGENT" );
 
   if( ereg( "Safari", $Agent ) ){
       print("<DIV id='footer-center'>");
       print("<PRE>");
       print("Phrase Separator System Version 2.2.4 \n");
       // print("Copyright(C.) 2014 <A HREF='mailto:naoshi01.watanuki@g.softbank.co.jp'><U>Softbank Co.Ltd.,</U></A> Allright Reserved.");
       print("Copyright(C.) 2019 <A HREF='mailto:nao-wata@primagest.co.jp'><U>Primagest.,Inc</U></A> Allright Reserved.");
       print("</PRE> \n");
       print("</DIV> \n");
   } else {
       print("<DIV id='footer-center'>");
       print("<PRE class='c5'>");
       print("Phrase Separator System Version 2.2.4 \n");
       // print("Copyright(C.) 2014 <A HREF='mailto:naoshi01.watanuki@g.softbank.co.jp'><U>Softbank Co.Ltd.,</U></A> Allright Reserved.");
       print("Copyright(C.) 2019 <A HREF='mailto:nao-wata@primagest.co.jp'><U>Primagest.,Inc</U></A> Allright Reserved.");
       print("</PRE> \n");
       print("</DIV> \n");
   }
?>
