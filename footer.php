<?php
  /*==========================================================================+
   | PHP version 7.1.16                                                       |
   +--------------------------------------------------------------------------+
   | Copyright (C) 2019.03.02 N.watanuki.                                     |
   +--------------------------------------------------------------------------+
   | Script-ID      : footer.php                                              |
   | DATA-WRITTEN   : 2018.07.25                                              |
   | AUTHER         : _.________                                              |
   | UPDATE-WRITTEN : ____.__.__                                              |
   +==========================================================================*/
   $Agent = getenv( "HTTP_USER_AGENT" );
 
   $pattern = "!Safari!";

   if(preg_match($pattern, $Agent)){
       print("<DIV id='footer-center'>");
       print("<PRE class='c5'>");
       print("Schedule Management System Version 2.2.4 \n");
       print("Copyright(C.) 2019 <A HREF='mailto:kosei.halfmoon@gmail.com'><U>N.WATANUKI</U></A> Allright Reserved.");
       print("</PRE> \n");
       print("</DIV> \n");
   } else {
       print("<DIV id='footer-center'>");
       print("<PRE class='c5'>");
       print("Schedule Management System Version 2.2.4 \n");
       print("Copyright(C.) 2019 <A HREF='mailto:kosei.halfmoon@gmail.com'><U>N.WATANUKI</U></A> Allright Reserved.");
       print("</PRE> \n");
       print("</DIV> \n");
   }
?>
