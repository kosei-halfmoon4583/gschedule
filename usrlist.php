<?php
  /*========================================================================+
   | PHP version 5.6.30                                                     |
   +------------------------------------------------------------------------+
   | Copyright (C) 2002.08.30                                               |
   +------------------------------------------------------------------------+
   | Script-ID      : usrlist.php                                           |
   | DATA-WRITTEN   : 2002.08.30                                            |
   | AUTHOR         : L. Tortona                                            |
   | UPDATE-WRITTEN : 2011.04.07                                            |
   | UPDATE-WRITTEN : 2018.03.18 Upgrade to a newer version.                |
   +========================================================================*/
/*--------------------*
 * User List Class    *
 *--------------------*/
class usrlist {
    var $href;
    var $content;
    var $sesUserID;
    /*------------------*
     *  DB Connection   *
     *------------------*/
    function connectDB() { 

        /* define("DBSV", "localhost"); */
        define("DBSV", "127.0.0.1");
        define("DBNAME", "gschedule");
        define("DBUSER", "nao");
        define("DBPASS", "naow4583");

        $conn = mysql_connect(DBSV, DBUSER, DBPASS) or 
            die("Could not connect to Database!: " . mysql_error($conn));
        mysql_select_db(DBNAME, $conn);
    }
    /*-----------------------------------------------------------------------*
     *  Function that handles the DB retrieval of data and printing of data. *
     *-----------------------------------------------------------------------*/
    function getUserList() {
    
        print ($this->content = $this->getUserInfo());
    
    }
    /*-----------------------------------------------------*
     *  Function that retrieves userID from the database.  *
     *-----------------------------------------------------*/
    function getUserInfo() {
    
      //MySQL DB Connect
        /* define("DBSV", "localhost"); */
        define("DBSV", "127.0.0.1");
        define("DBNAME", "gschedule");
        define("DBUSER", "nao");
        define("DBPASS", "naow4583");

        $conn = mysql_connect(DBSV, DBUSER, DBPASS) or 
            die("Could not connect to Database!: " . mysql_error($conn));
        mysql_select_db(DBNAME, $conn);

        $l_strSql = "SELECT userid, jpname FROM accounttb ORDER by jpname";

        //Execute query for User ID retrieval.
        $l_resOut = mysql_query($l_strSql, $conn);
        
        //Get Number of Rows.
        $l_intNoRow = mysql_num_rows($l_resOut);  
        
        //Initialize return values
        $l_strReturnValue = "<OPTION value='  '>全　員</OPTION>\n";
        
        //Check if there are no data retrieved.
        if ($l_intNoRow == 0) {
            //$l_strReturnValue .= "</SELECT>";
            //Disconnect from the database.
            mysql_close($conn);
            //Return value with no data.
            return($l_strReturnValue);
        }
        //If data were retrieved perform loop to retrieve all data..
        while ($l_objRowData = mysql_fetch_assoc($l_resOut)) {
         
            //Get Data.
            $l_strUserID   = $l_objRowData["userid"];
            $l_strUsername = $l_objRowData["jpname"];
            
            //Set data onto the display window.
            $l_strReturnValue .= "<OPTION value='";
            $l_strReturnValue .= $l_strUserID ;
            $l_strReturnValue .= "'>";
            $l_strReturnValue .= $l_strUsername;
            $l_strReturnValue .= "</OPTION>\n";
        }
        
        //Disconnect from the database.
        mysql_close($conn);
        
        //Set end marker and return value.
        //$l_strReturnValue .= "</SELECT>";
        return($l_strReturnValue);
    }
}
?>
