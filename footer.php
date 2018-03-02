<?php
  /*==========================================================================+
   | PHP version 4.4.2                                                        |
   +--------------------------------------------------------------------------+
   | Copyright (C) 2002.07.16 N.watanuki                                      |
   +--------------------------------------------------------------------------+
   | Script-ID      : footer.php                                              |
   | DATA-WRITTEN   : 2010.03.12                                              |
   | AUTHER         : N.WATANUKI                                              |
   | UPDATE-WRITTEN : 2011.02.04                                              |
   +==========================================================================*/
   $Agent = getenv( "HTTP_USER_AGENT" );
 
   if( ereg( "Safari", $Agent ) ){
       print("<DIV id='footer-center'>");
       print("<PRE>");
       print("Schedule Management System Version 2.2.4 \n");
       print("Copyright(C.) 2009 <A HREF='mailto:kosei.halfmoon@gmail.com'><U>Naoshi WATANUKI.</U></A> Allright Reserved.");
       print("</PRE> \n");
       print("</DIV> \n");
   } else {
       print("<DIV id='footer-center'>");
       print("<PRE class='c5'>");
       print("Schedule Management System Version 2.2.4 \n");
       print("Copyright(C.) 2009 <A HREF='mailto:kosei.halfmoon@gmail.com'><U>Naoshi WATANUKI.</U></A> Allright Reserved.");
       print("</PRE> \n");
       print("</DIV> \n");
   }
?>
