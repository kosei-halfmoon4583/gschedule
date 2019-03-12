<?php
  /*========================================================================+
   | PHP version 7.1.16                                                     |
   +------------------------------------------------------------------------+
   | Copyright (C) 2018.07.25                                               |
   +------------------------------------------------------------------------+
   | Script-ID      : wschd.php                                             |
   | DATA-WRITTEN   : 2018.07.25                                            |
   | AUTHOR         : _.________                                            |
   | UPDATE-WRITTEN : 2019.03.12                                            |
   +========================================================================*/
    /*------------------*
     * User List Class  *
     *------------------*/
    class usrschddb {

        var $content; //Variable that will store the html to be printed.

        /*--------------------------------------------*
         *  Function that will initialize this class. *
         *--------------------------------------------*/
        function usrschddb () {
            //Empty Constructor
        }
        /*---------------------------------------------------------------------*
         * DB Connection (connectDB()が関数として定義されているが使用しない？) *
         *---------------------------------------------------------------------*/
         function connectDB () {

            //MySQL DB Connect
            define("DBSV", "127.0.0.1");
            define("DBNAME", "gschedule");
            define("DBUSER", "nao");
            define("DBPASS", "naow4583");

            $conn = mysqli_connect(DBSV, DBUSER, DBPASS, DBNAME);
            if(mysqli_connect_error()){
                die("Could not connect to Database!: " . mysqli_error($conn));
            }
        }
        /*----------------------------------------------------------------------*
         * Function that handles the DB retrieval of data and printing of data. *
         *----------------------------------------------------------------------*/
        function getUserData ($p_strUserID, $p_strYear, $p_strMonth) {
            print ($this->content = $this->getUserSchedInfo($p_strUserID, $p_strYear, $p_strMonth));
            return 0;
        }
        /*--------------------------------------------------------------------------------*
         * Function that retrieves user schedule and other information from the database. *
         *--------------------------------------------------------------------------------*/
        function getUserSchedInfo ($p_strUserID, $p_strYear, $p_strMonth) {

            /*- [ Variable declaration ] -----------------------------------*
              var $l_resOut;          Result Set
              var $l_intNoRow;        Row Counter
              var $l_objRowData;      Row data of selected information.
              var $l_strReturnValue;  Return value storage variable.
              var $l_strUsername;     Name of the selected user.
              var $l_strEmail;        Email address of the selected user.
              var $l_strReportDate;   Report date
              var $l_strStartTime;    Start time
              var $l_strEndTime;      End time
              var $l_strContents;     Schedule contents.
              var $l_strSql;          SQL Query String
             *--------------------------------------------------------------*/

         // Perform DB Connection
            define("DBSV", "127.0.0.1");
            define("DBNAME", "gschedule");
            define("DBUSER", "nao");
            define("DBPASS", "naow4583");

            $conn = mysqli_connect(DBSV, DBUSER, DBPASS, DBNAME);
            if(mysqli_connect_error()){
                die("Could not connect to Database!: " . mysqli_error($conn));
            }
            
            //Set SQL to retrieve nihongo name and e-mail address.
            $l_strSql  = " SELECT jpname, email";
            $l_strSql .= " FROM accounttb";
            $l_strSql .= " WHERE accounttb.userid = '" . $p_strUserID . "'";

            //Execute query for User ID retrieval.
            $l_resOut = mysqli_query($conn, $l_strSql);

            //Get Number of Rows.
            $l_intNoRow = mysqli_num_rows($l_resOut);  

            //Initialize return values
            $l_strReturnValue = "<td width='550' height='40' nowrap>\n";

            //Check if there are no data retrieved.
            if ($l_intNoRow == 0) {
                //Disconnect from the database.
                mysqli_close($conn);
                //Return value with no data.
                return ($l_strReturnValue);
            }

            //Retrieve japanese name and e-mail address.
            if ( $l_objRowData = mysqli_fetch_assoc($l_resOut) ) {
                                 
                $l_strUsername = $l_objRowData["jpname"];
                $l_strEmail    = $l_objRowData["email"];

                //Set data that were retrieved on the return value.
                $l_strReturnValue .= "<font color='#FF5500'><A href='mailto://" . $l_strEmail . "'>\n";
                $l_strReturnValue .= $l_strUsername;
                $l_strReturnValue .= "</A>";

                // Free result set.
                mysqli_free_result($l_resOut);
            }

            //Set closing HTML column marking.
            $l_strReturnValue .= "</TD>\n";

            // Set SQL statement to retrieve the schedule of the user
            // for the passed year and month..
            $l_strSql  = " SELECT sdate, sstime, setime, cont2";
            $l_strSql .= " FROM schdtb";
            $l_strSql .= " WHERE suserid = '" . $p_strUserID . "' AND";
            $l_strSql .= " year(sdate) = '" . $p_strYear . "' AND";
            $l_strSql .= " month(sdate) = '" . $p_strMonth . "' ";
            $l_strSql .= " ORDER by sdate, sstime, setime";

            //Execute query for User ID retrieval.
            $l_resOut = mysqli_query($conn, $l_strSql);

            //Get Number of Rows.
            $l_intNoRow = 0;
            $l_intNoRow = mysqli_num_rows($l_resOut);  

            //Setup screen for the initial data.
            $l_strReturnValue .= "</tr>\n";
            $l_strReturnValue .= "</table>\n";

            //Check if there are no data retrieved.
            if ($l_intNoRow == 0) {

                //Set information that there's no user work schedule for the month.
                $l_strReturnValue .= "<b><font size='2'>選択されたユーザに関連付けられた予定は登録されていません。</font></b>\n";
                //$l_strReturnValue .= "</center>\n";
                //$l_strReturnValue .= "</div>\n";

                //Disconnect from the database.
                mysqli_close($conn);
                //Return value with no data.
                return ($l_strReturnValue);
            }

          //Setup the table where data will be displayed.
            $l_strReturnValue .= "<table border='1' cellspacing='1' cellpadding='2' bordercolorlight='#000080' bordercolordark='#3366CC' width='650' >\n";
            $l_strReturnValue .= "<tr height='15'>\n";
            $l_strReturnValue .= "<td class='c4'>\n";
            $l_strReturnValue .= "<font size='2' color='#FFFFFF'>&nbsp;予定日時&nbsp;</font>\n";
            $l_strReturnValue .= "</td>\n";
            $l_strReturnValue .= "<td class='c4'>\n";
            $l_strReturnValue .= "<font size='2' color='#FFFFFF'>&nbsp;開始予定&nbsp;</font>\n";
            $l_strReturnValue .= "</td>\n";
            $l_strReturnValue .= "<td class='c4'>\n";
            $l_strReturnValue .= "<font size='2' color='#FFFFFF'>&nbsp;終了予定&nbsp;</font>\n";
            $l_strReturnValue .= "</td>\n";
            $l_strReturnValue .= "<td class='c4'>\n";
            $l_strReturnValue .= "<font size='2' color='#FFFFFF'>&nbsp;予定内容&nbsp;</font>\n";
            $l_strReturnValue .= "</td>\n";
            $l_strReturnValue .= "</tr>\n";

            //If data were retrieved perform loop to retrieve all data..
            while ($l_objRowData = mysqli_fetch_assoc($l_resOut)) {
                                   
                //Get Data.
                $l_strReportDate = $l_objRowData["sdate"];    //Report date
                $l_strTemp       = $l_objRowData["sstime"];   //Start time

              //Check for the formatting of the time field.
                if (strlen($l_strTemp) == 4) {

                    $l_strStartTime = substr ($l_strTemp, 0, 2) . ":" . substr ($l_strTemp, 2, 2);

                } elseif ( strlen($l_strTemp) == 3 ) {

                    $l_strStartTime = substr ($l_strTemp, 0, 1) . ":" . substr ($l_strTemp, 1, 2);

                } else {

                    $l_strStartTime = $l_strTemp;

                }

                $l_strTemp = $l_objRowData["setime"];       //End time

              //Check for the formatting of the time field.
                if (strlen($l_strTemp) == 4) {

                    $l_strEndTime = substr ($l_strTemp, 0, 2) . ":" . substr ($l_strTemp, 2, 2);

                } elseif ( strlen($l_strTemp) == 3 ) {

                    $l_strEndTime = substr ($l_strTemp, 0, 1) . ":" . substr ($l_strTemp, 1, 2);

                } else {

                    $l_strEndTime = $l_strTemp;

                }

                $l_strContents    = $l_objRowData["cont2"];     //Schedule contents

              //Set data onto the display window.
                $l_strReturnValue .= "<tr height= '5'>\n";
                $l_strReturnValue .= "<td width='80' align='center' bgcolor = white nowrap>\n";
                $l_strReturnValue .= "<font size='2'>" . $l_strReportDate . "</font>\n";
                $l_strReturnValue .= "</td>\n";
                $l_strReturnValue .= "<td width='80' align='center' bgcolor = white nowrap>\n";
                $l_strReturnValue .= "<font size='2'>" . $l_strStartTime . "</font>\n";
                $l_strReturnValue .= "</td>\n";
                $l_strReturnValue .= "<td width='80' align='center' bgcolor = white nowrap>\n";
                $l_strReturnValue .= "<font size='2'>" . $l_strEndTime . "</font>";
                $l_strReturnValue .= "</td>\n";
                $l_strReturnValue .= "<td width='350' align='left' bgcolor = white>\n";
                $l_strReturnValue .= "<font size='2'>" . $l_strContents . "</font>\n";
                $l_strReturnValue .= "</td>\n";
                $l_strReturnValue .= "</tr>\n";
            }

            //Disconnect from the database.
            mysqli_free_result($l_resOut);
            mysqli_close($conn);

            //Set end marker and return value.
            return ($l_strReturnValue);
        }
    }
?>
