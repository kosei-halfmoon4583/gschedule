<?php
session_start();
/* +======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : todoin.php                                          |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");  
    require_once("footer.php"); //footer(outer file.)
    $header_title = "[ ToDo登録 ]";
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html;CHARSET=UTF-8">
<TITLE>ToDo登録</TITLE>
<link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />
<script type="text/javascript">
function formCftodo() {
    if (document.todoadd.tyear.value == "") {   
        alert("年を入力して下さい");
        document.todoadd.tyear.focus();
        return(false);
    }
    if (document.todoadd.tmonth.value == "") {  
        alert("月を入力して下さい");
        document.todoadd.tmonth.focus();
        return(false);
    }
    if (document.todoadd.tday.value == "") {    
        alert("日を入力して下さい");
        document.todoadd.tday.focus();
        return(false);
    }
    if (document.todoadd.todo.value == "") {    
        alert("Todo内容を入力して下さい");
        document.todoadd.todo.focus();
        return(false);
    }
    rtn = confirm("書き込みます。\nよろしいですか？");
    if (rtn) {
        return(true);
    } 
    return(false);
}
</script>
</HEAD>

<BODY onload="document.todoadd.todo.focus()">
<?php require_once("header.php"); ?>
<div id="content">
<!-- <div id="header"> -->
<div id="menu-ad">
<pre style="color:#3399CC;">
 [ 広告エリア ]
</pre>
</div>

<div id="main3">
<?php
/* todo.phpから追加ボタンで遷移してきた場合、todoは空白のはずなので、$todo変数には空白をセットする。*/
    if (!isset($_SESSION["stodo"])) {
        $today = getdate();
        $tyear = $today["year"];
        $tmonth = sprintf("%02d",$today["mon"]);  // 0がパディング文字
        $tday = sprintf("%02d",$today["mday"]);   // 0がパディング文字
        $crename =  $sesjpname;
        $todo = '';
    } else {   /*todo.phpから変更ボタンで遷移してきた場合、todoには登録済みのtodoが入力されているはず */
        $tyear = $_SESSION["stodo"][0];
        $tmonth = $_SESSION["stodo"][1];
        $tday = $_SESSION["stodo"][2];
        $todo = $_SESSION["stodo"][3];
        $crename = $_SESSION["stodo"][4];
    }

//-- ToDo入力フォーム
    print ("<FORM name ='todoadd' action='todoinsub.php' method='post'> \n");
    print ("<TABLE border='1' cellspacing='1' cellpadding='2' bordercolorlight='#7E1EFF' bodercolordark='#2400A5'> \n");
    print ("<TR><TD class='c4'>&nbsp;内　容&nbsp;</TD> \n");
    print ("<TD class='c2'> \n");
    print ("<INPUT type='text' name='todo' value='$todo' size=80> \n");
    print ("</TD></TR> \n");
    print ("<TR><TD class='c4'>&nbsp;期　日&nbsp;</TD> \n");
    print ("<TD class='c2'><input type='text' name='tyear' value='$tyear' size=4> \n");
    print ("<FONT color='#330099'>年</FONT> \n");
    print ("<INPUT type='text' name='tmonth' value='$tmonth' size=2> \n");
    print ("<FONT color='#330099'>月</FONT> \n");
    print ("<INPUT type='text' name='tday' value='$tday' size=2> \n");
    print ("<FONT color='#330099'>日</FONT> \n");
    print ("</TD></TR>");
    print ("<TR> \n");
    print ("<TD class='c4'>&nbsp;登録者&nbsp;</TD>\n");
    print ("<TD class='c2'><input type='text' name='crename' value='$crename' readonly> \n");
    print ("</TD></TR> \n");
    print ("</TABLE><BR> \n");
    print ("<INPUT type='submit' value='登録' onClick='return formCftodo()'><BR><BR> \n");
    print ("<A href='todo.php'><img src='./resources/images/ico_back1_10.gif' height='15' width='60'></A> \n");
    print ("</FORM> \n");
?>
</div>
</div>
</BODY>
</HTML>
