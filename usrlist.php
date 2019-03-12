<?php
  /*========================================================================+
   | PHP version 7.1.16                                                     |
   +------------------------------------------------------------------------+
   | Copyright (C) 2018.07.25                                               |
   +------------------------------------------------------------------------+
   | Script-ID      : usrlist.php                                           |
   | DATA-WRITTEN   : 2018.07.25                                            |
   | AUTHOR         : _.________                                            |
   | UPDATE-WRITTEN : 2019.03.12                                            |
   +========================================================================*/
    // require_once("db_connect.php");
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

            define("DBSV", "127.0.0.1");
            define("DBNAME", "gschedule");
            define("DBUSER", "nao");
            define("DBPASS", "naow4583");

            $conn = mysqli_connect(DBSV,DBUSER,DBPASS,DBNAME);
            if(mysqli_connect_error()) {
                die("Error: DBへの接続に失敗しました！");
            }
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


            // MySQL DB Connect
            require_once("db_connect.php");
        
            $l_strSql = "SELECT userid, jpname FROM accounttb ORDER by jpname";

            //Execute query for User ID retrieval.
            $l_resOut = mysqli_query($conn, $l_strSql);
            
            //Get Number of Rows.
            $l_intNoRow = mysqli_num_rows($l_resOut);  
            
            //Initialize return values
            $l_strReturnValue = "<OPTION value='  '>登録ユーザ</OPTION>\n";
            
            //Check if there are no data retrieved.
            if ($l_intNoRow == 0) {
                //$l_strReturnValue .= "</SELECT>";
                //Disconnect from the database.
                mysqli_close($conn);
                //Return value with no data.
                return($l_strReturnValue);
            }
            //If data were retrieved perform loop to retrieve all data..
            while ($l_objRowData = mysqli_fetch_assoc($l_resOut)) {
             
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
            mysqli_close($conn);
            
            //Set end marker and return value.
            //$l_strReturnValue .= "</SELECT>";
            return($l_strReturnValue);
        }
    }
?>
