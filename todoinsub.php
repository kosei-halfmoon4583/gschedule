<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : todoinsub.php                                       |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");      
    require_once("db_connect.php"); //DB Connect.

    $tyear = $_POST["tyear"];
    $tmonth = $_POST["tmonth"];
    $tday = $_POST["tday"];
    $todo = $_POST["todo"];

    if (!isset($stodo)) { 
        $_SESSION["stodo"] = array();
        $stodo[0] = $tyear;
        $stodo[1] = $tmonth;
        $stodo[2] = $tday;
        $stodo[3] = $todo;
    } else {
        // テーブルから読み込んだ値を保存
        $stid = $_SESSION["stid"];
        $stodo[0] = $tyear;
        $stodo[1] = $tmonth;
        $stodo[2] = $tday;
        $stodo[3] = $todo;
    }
    // 更新チェック
    $updflg = $sesadmin;
    if (isset($stid)) { // Update
        $sql = "select * from todotb where tid = $stid";
        $res = mysqli_query($conn, $sql);
        $nbrows = mysqli_num_rows($res);  

        // 他のユーザーにレコードが削除されていた場合
        if($nbrows == 0) {
            print ("<HTML> \n");
            print ("<HEAD> \n");
            print ("<META http-equiv='Content-Type' content='text/html;CHARSET=UTF-8'> \n");
            print ("<link rel='stylesheet' type='text/css' href='./resources/css/gs.css' /> \n");
            print ("<TITLE>ToDo更新エラー</TITLE> \n");
            print ("</HEAD> \n");
            print ("<BODY> \n");
            print ("<div id='content'> \n");
            $header_title = "[ ToDo更新 Error! ]";
            require_once("header.php");
            print ("<div id='menu'> \n");
            print ("<pre style='color:#FFFFFF;'>.</pre> \n");
            print ("</div> \n");
            print ("<div id='main3'> \n");    
            print ("<FONT color='red'>あなたが編集中に他のユーザーにより削除されました！</FONT><BR><BR>");
            print ("<a href=todo.php>戻る</a>");    
            print ("</div> \n");
            print ("</div> \n");
            print ("</BODY> \n");
            print ("</HTML> \n");
            exit;
        }
        $row = mysqli_fetch_assoc($res);
        if ($sesLoginID == $row["tuserid"]) {
            $updflg = 1;        //自分が書込んだTodo内容の場合
        }
        mysqli_free_result($res);
        if ($updflg != 1) {
            print ("<font color = red>変更できません。</font><br>"); 
            print ("<a href=todo.php>戻る</a>");    
            exit;
        }
        if ((trim($oldtodo[1]) != trim($row["todo"])) or 
            (trim($oldtodo[0]) != trim($row["tdate"]))) {
            $pdate = substr($row["tdate"],0,4) ."/" .substr($row["tdate"],5,2) ."/" .substr($row["tdate"],8,2);
            print ("<HTML> \n");
            print ("<HEAD> \n");
            print ("<META http-equiv='Content-Type' content='text/html;CHARSET=UTF-8'> \n");
            print ("<link rel='stylesheet' type='text/css' href='./resources/css/gs.css' /> \n");
            print ("<TITLE>ToDo変更エラー</TITLE> \n");
            print ("</HEAD> \n");
            print ("<BODY> \n");
            print ("<div id='content'> \n");
            $header_title = "[ ToDo変更 Error! ]";
            require_once("header.php");
            print ("<div id='menu'> \n");
            print ("<pre style='color:#FFFFFF;'>.</pre> \n");
            print ("</div> \n");
            print ("<div id='main3'> \n");    
            print ("<FONT color='red'>あなたが編集中に他のユーザーにより変更されました！</FONT><BR><BR>");
            print ("Todo内容：" .trim($row["todo"]) ."<br>");
            print ("期日：" .$pdate ."<br>"); 
            print ("<a href='todo.php'>[ 戻る ]</a>");    
            print ("</div> \n");
            print ("</div> \n");
            print ("</BODY> \n");
            print ("</HTML> \n");
            exit;
        }
    }
    if (!checkdate($tmonth,$tday,$tyear)) {
        print "日付が無効です。<BR>";
        print "<a href='todoin.php'>再入力してください。</a>";
        exit;
    }
    // 文字数（バイト数）チェック
    if (strlen($todo) > 80 ) {
        print "<a href='todoin.php'>Todo内容は80文字（日本語40文字）以内で入力してください。</a>";
        exit;
    }
    
    $tdate = $tyear ."/" . $tmonth . "/" . $tday;
    if (!isset($_SESSION["stid"])) {
        $sql = "insert into todotb(tdate,todo,tuserid)"; 
        $sql .= " values('$tdate','$todo','$sesLoginID')";
        $res = mysqli_query($conn, $sql);
    } else {
        $stid = $_SESSION["stid"];
        $pdate = substr($oldtodo[0],0,4) ."/" .substr($oldtodo[0],5,2) ."/" .substr($oldtodo[0],8,2);
        $sql = "update todotb set tdate='$tdate' ,todo='$todo' "; 
        $sql .= " where tid=" . $stid;
        $res = mysqli_query($conn, $sql);
    }

    if(mysqli_error($conn)) {
        print "レコードの更新に失敗しました！";
        echo mysqli_errno($conn) . ": " . mysqli_error($conn) . "\n";
        session_destroy();
        mysqli_free_result($result);
        mysqli_close($conn);
        exit;
    } else {
    /* 正常に更新完了todo.phpへ戻る */
        header("Location: todo.php");
    }

    /*=========================================================*
     * <Tag>付けSample Logic *Tag付けされたKeywordがTodo内容に *
     * 含まれている場合に、画面の遷移先を変える。              *
     *=========================================================*/
    $query = "SELECT kid, kwd, kurl, kusr, kemail, kdate, kcont FROM kwordtb";
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

        $shoten = getSubStringFromKeyword($todo, $keywd);
        if($shoten != null) {
            header("Location: $turl");
        }
    }

    function getSubStringFromKeyword($todo, $keywd){
        $pos = mb_strpos($todo, $keywd);
        if($pos === false){
            return null;
        }
        return mb_substr($todo, $pos);
    }
?>
