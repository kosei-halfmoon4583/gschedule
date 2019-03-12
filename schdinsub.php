<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : schdinsub.php                                       |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");
    require_once("db_connect.php");
    require_once("sesReg.php");
    
/* [開始/終了時間 POST from schdin.php] */
    $h_start = $_POST["starthour"];
    $m_start = $_POST["startmin"];
    $h_end   = $_POST["endhour"];
    $m_end   = $_POST["endmin"];

/* [予定内容 POST from schdin.php] */
    $tyear = $_POST["tyear"];
    $tmonth = $_POST["tmonth"];
    $tday = $_POST["tday"];
    $cont1 = $_POST["cont1"];
    $cont2 = $_POST["cont2"];

/* [予定日付 POST from schdin.php] */
    $_SESSION["sRet"][0] = $tyear;
    $_SESSION["sRet"][1] = $tmonth;
    $_SESSION["sRet"][2] = $tday;
    
    //更新チェック($ssidがセットされていれば削除、または変更
    $updflg = $sesadmin;
    if (isset($_SESSION["ssid"])) {
        
        $ssid = $_SESSION["ssid"];

        $sql = "SELECT * FROM schdtb WHERE sid = $ssid";
        $res = mysqli_query($conn, $sql);
        $nbrows = mysqli_num_rows($res);  
        
        if($nbrows == 0) {
            print ("<HTML> \n");
            print ("<HEAD> \n");
            print ("<META http-equiv='Content-Type' content='text/html;CHARSET=UTF-8'> \n");
            print ("<link rel='stylesheet' type='text/css' href='./resources/css/gs.css' /> \n");
            print ("<TITLE>予定更新エラー</TITLE> \n");
            print ("</HEAD> \n");
            print ("<BODY> \n");
            print ("<div id='content'> \n");
            $header_title = "[ 予定更新 Error! ]";
            require_once("header.php");
            print ("<div id='menu'> \n");
            print ("<pre style='color:#FFFFFF;'>.</pre> \n");
            print ("</div> \n");
            print ("<div id='main3'> \n");    
            print ("<FONT color='red'>あなたが編集中に他のユーザーにより削除されました！</FONT><BR><BR>");
            print ("<A href=schd.php?year=$sRet[0]&month=$sRet[1]&day=$sRet[2]>[ 戻る ]</A>");
            print ("</div> \n");
            print ("</div> \n");
            print ("</BODY> \n");
            print ("</HTML> \n");
            exit;
        }

        $row = mysqli_fetch_assoc($res);
        $pdate = substr($row["sdate"],0,4) ."/" .substr($row["sdate"],5,2) ."/" .substr($row["sdate"],8,2);
        if ($sesLoginID == $row["suserid"]) {
            $updflg = 1;  // 自分が書込んだ予定の場合
        }
        if ($updflg != 1) {
            if ((isset($delFlag))&&($delFlag == "t" )) {
                print ("<FONT color='red'>削除できません。</FONT><BR>");
            } else { 
                print ("<FONT color='red'>変更できません。</FONT><BR>");
            }
            print ("<A href=schd.php?year=$sRet[0]&month=$sRet[1]&day=$sRet[2]>[ 戻る ]</A>");
            exit;
        }

        $oldschd[0] = $_SESSION["oldschd"][0];
        $oldschd[1] = $_SESSION["oldschd"][1];
        $oldschd[2] = $_SESSION["oldschd"][2];
        $oldschd[3] = $_SESSION["oldschd"][3];
        $oldschd[4] = $_SESSION["oldschd"][4];
        $oldschd[5] = $_SESSION["oldschd"][5];
        $oldschd[6] = $_SESSION["oldschd"][6];

        if ((trim($oldschd[0]) != trim($row["sdate"])) 
            or (trim($oldschd[1]) != substr($row["sstime"],0,2))
            or (trim($oldschd[2]) != substr($row["sstime"],2,2))
            or (trim($oldschd[3]) != substr($row["setime"],0,2))
            or (trim($oldschd[4]) != substr($row["setime"],2,2))
            or (trim($oldschd[5]) != trim($row["cont1"]))
            or (trim($oldschd[6]) != trim($row["cont2"]))) {
            print ("<HTML> \n");
            print ("<HEAD> \n");
            print ("<META http-equiv='Content-Type' content='text/html;CHARSET=UTF-8'> \n");
            print ("<link rel='stylesheet' type='text/css' href='./resources/css/gs.css' /> \n");
            print ("<TITLE>予定更新エラー</TITLE> \n");
            print ("</HEAD> \n");
            print ("<BODY> \n");
            print ("<div id='content'> \n");
            $header_title = "[ 予定更新 Error! ]";
            require_once("header.php");
            print ("<div id='menu'> \n");
            print ("<pre style='color:#FFFFFF;'>.</pre> \n");
            print ("</div> \n");
            print ("<div id='main3'> \n");    
            print ("<FONT color='red'>あなたが編集中に他のユーザーにより変更されました。</FONT><BR><BR>");
            print ("日　付：&nbsp; for dubug 2018/02/19" .$pdate ."<BR>");
            print ("開始時間：&nbsp;" .substr($row["sstime"],0,2) .":" .substr($row["sstime"],2,2) ."<BR>");
            print ("終了時間：&nbsp;" .substr($row["setime"],0,2) .":" .substr($row["setime"],2,2)."<BR>");
            print ("内　容：&nbsp;" .$row["cont1"] ."<BR>");
            print ("詳　細：&nbsp;" .$row["cont2"] ."<BR><BR>");
            print ("<A href=schd.php?year=$sRet[0]&month=$sRet[1]&day=$sRet[2]>[ 戻る ]</A>");
            print ("</div> \n");
            print ("</div> \n");
            print ("</BODY> \n");
            print ("</HTML> \n");
            exit;
        }
    }
    if ((isset($delFlag))&&($delFlag == "t" )) {
        $sql = "DELETE FROM schdtb WHERE sid = $ssid";
    } else {
        sesReg_sschd();

        $_SESSION["sschd"][0] = $tyear;
        $_SESSION["sschd"][1] = $tmonth;
        $_SESSION["sschd"][2] = $tday;
        $_SESSION["sschd"][3] = $h_start;
        $_SESSION["sschd"][4] = $m_start;
        $_SESSION["sschd"][5] = $h_end;
        $_SESSION["sschd"][6] = $m_end;
        $_SESSION["sschd"][7] = $cont1;
        $_SESSION["sschd"][8] = $cont2;

        /*---------------------------------------*
         *   項目チェック                        *
         *---------------------------------------*/
        if (!checkdate($tmonth,$tday,$tyear)) {
            print "日付が無効です。<BR>";
            print "<a href=schdin.php>再入力してください。</a>";
            exit;
        }
        // 文字数（バイト数）チェック
        if (strlen($cont1) >= 30 ) {
            print "<a href='schdin.php'>>内容は30文字（日本語15文字）以内で入力して下さいね。</a>";
            exit;
        }
        if (strlen($cont2) > 80 ) {
            print "<a href='schdin.php'>詳細は80文字（日本語40文字）以内で入力してください。</a>";
            exit;
        }
        $sdate = $tyear ."/" . $tmonth . "/" . $tday;
        $sstime = sprintf("%02d",$h_start) . sprintf("%02d",$m_start);
        if (empty($h_end) and empty($m_end)) {
            $setime="";
        } else {
            $setime = sprintf("%02d",$h_end) . sprintf("%02d",$m_end);
        }
        /*---------------------------------------*
         * レコードの更新                        *
         * schdtbテーブル                        *
         *---------------------------------------*/
        if (!isset($_SESSION["ssid"])) {
            $sql = "insert into schdtb(sdate,sstime,setime,cont1,cont2,suserid)"; 
            $sql .= " values('$sdate','$sstime','$setime','$cont1','$cont2','$sesLoginID')";
        } else {
            $sql = "update schdtb set sdate='$sdate', sstime='$sstime', setime='$setime',"; 
            $sql .= " cont1='$cont1', cont2='$cont2'"; 
            $sql .= " where sid=" . $ssid;
        }
    }

    $res = mysqli_query($conn, $sql);

    if(mysqli_error($conn)) {
        print("レコードの更新に失敗しました。\n");
        print("<BR>");
        echo mysqli_errno($conn) . ": " . mysqli_error($conn) . "\n";
        session_destroy();
        mysqli_free_result($res);
        mysqli_close($conn);
        exit;
    } else {
        
      /*============================================*
       * <Tag>付けSample Logic                      *
       *  Tag付けされたKeywordがTodo内容に          *
       *  含まれている場合に、画面の遷移先を変える。*
       *============================================*/
        $query = "SELECT kid, kwd, kurl FROM kwordtb";
        $result = mysqli_query($conn, $query);
        $nbrows = mysqli_num_rows($result);  

        // 結果チェック(Error Check)
        if(!$result) {
            $message  = 'Invalid query: ' . mysqli_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        }

        for ($i = 1; $i <= $nbrows; $i++) {
            $row = mysqli_fetch_assoc($result);
            $keywd = $row['kwd'];
            $turl = $row['kurl'];

            $shoten = getSubStringFromKeyword($cont2, $keywd);
            if($shoten != null) {
                header("Location: $turl");
                exit;
            }
        }
    }
    mysqli_free_result($res);
    mysqli_close($conn);
    
   /*----------------------------------------------------------*
      仮 修正：sRet[0] - sRet[1] に値がセットされていない。    *
      仮修正として、$tyear, $tmonth, $tdayをそれぞれ、         *
      sRet[0],sRet[1],sRet[2]へ転送して画面遷移を行うよう修正。*
    *----------------------------------------------------------*/
    $sRet = array();
    $sRet[0] = $_SESSION["sRet"][0];
    $sRet[1] = $_SESSION["sRet"][1];
    $sRet[2] = $_SESSION["sRet"][2];
    header("Location:schd.php?year=$sRet[0]&month=$sRet[1]&day=$sRet[2]");
    exit;

   /*-----------------------------------------------*
    * 対象キーワードが登録されているかチェックする  *
    *-----------------------------------------------*/
    function getSubStringFromKeyword($cont2, $keywd){
        $pos = mb_strpos($cont2, $keywd);
        if($pos === false){
            return null;
        }
        return mb_substr($cont2, $pos);
    }
?>
